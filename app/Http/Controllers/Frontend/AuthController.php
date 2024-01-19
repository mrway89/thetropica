<?php

namespace App\Http\Controllers\Frontend;

use App\Content;
use App\User;
use App\UserReferral;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mail;
use Session;
use Socialite;
use Validator;

class AuthController extends CoreController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest')->except('logout');
    }

    public function loginIndex(Request $request)
    {
        if ($request->ref) {
            session()->forget('referral_code');
            $id   = preg_replace('/[^0-9,.]/', '', $request->ref);
            $user = User::find($id);

            if ($user) {
                session(['referral_code' => $request->ref]);
            }
        }

        if (!session()->has('url.intended')) {
            session(['url.intended' => url()->previous()]);
        }
        if (\Auth::check()) {
            return redirect()->route('frontend.home');
        }

        return $this->renderView('frontend.login.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'login_email'          => 'required',
                'login_password'       => 'required|string',
            ],
            [
                'login_email.required'              => $this->data['trans']['login_email_required'],
                'login_password.required'           => $this->data['trans']['login_password_required'],
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            // using email

            // $usingEmail = User::where('email', $request->login_email)->first();
            // $usingPhone = User::where('phone', $request->login_email)->first();

            $phone = false;
            if (filter_var($request->login_email, FILTER_VALIDATE_EMAIL)) {
                $user = User::where('email', $request->login_email)->first();
            } else {
                $phone = true;
                $user  = User::where('phone', (int) $request->login_email)->first();
            }

            if ($user) {
                if ($phone) {
                    // using phone
                    if ($user->verification_status == 1) {
                        if (Auth::attempt(['phone' => (int) $request->login_email, 'password' => $request->login_password], isset($request->remember))) {
                            $this->setCookiesDuration();

                            return redirect($request->previous);
                        }
                    } else {
                        return back()->withInput()->with('error_confirmation', 'Your account have not verified, please check your email to confirm your account');
                    }
                } else {
                    if ($user->verification_status == 1) {
                        if (Auth::attempt(['email' => $request->login_email, 'password' => $request->login_password], isset($request->remember))) {
                            $this->setCookiesDuration();

                            return redirect($request->previous);
                        }
                    } else {
                        return back()->withInput()->with('error_confirmation', 'Your account have not verified, please check your email to confirm your account');
                    }
                }
            } else {
                return back()->withInput()->with('error_confirmation', 'Cannot find account, please register');
            }

            return redirect()->back()->withInput($request->only('login_email', 'remember'))->withErrors([
                'login_password' => $this->data['trans']['login_account_wrong'],
            ]);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'register_email'    => 'required|string|email|max:255|unique:users,email',
                'register_phone'    => 'nullable|phone:ID|unique:users,phone',
                'register_name'     => 'required|max:255',
                'company_name'      => 'required|max:255',
                'agree'             => 'accepted'
            ],
            [
                'register_email.required'          => $this->data['trans']['register_email_required'],
                'register_email.email'             => $this->data['trans']['register_email_email'],
                'register_email.unique'            => $this->data['trans']['register_email_unique'],
                'register_phone.phone'             => $this->data['trans']['register_phone_phone'],
                'register_phone.unique'            => $this->data['trans']['register_phone_unique'],
                'register_password.required'       => $this->data['trans']['register_password_required'],
                'register_password.min'            => $this->data['trans']['register_password_min'],
                'register_name.required'           => $this->data['trans']['register_name_required'],
                'register_name.max'                => $this->data['trans']['register_name_max'],
                'agree.accepted'                   => $this->data['trans']['register_agree_accepted'],
                'company_name.required'            => $this->data['trans']['company_name_required'],
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            $verification_code = rand(111111, 999999);
            $user              = User::create([
                'email'             => $request->register_email,
                'provider'          => 'Origin',
                'phone'             => $request->register_phone,
                'name'              => ucwords($request->register_name),
                'verification_code' => $verification_code,
                'password'          => bcrypt($request->register_password),
                'company_name'      => $request->company_name
            ]);

            if (session()->has('referral_code')) {
                $id     = preg_replace('/[^0-9,.]/', '', session()->get('referral_code'));
                $upline = User::find($id);

                $referrer               = new UserReferral;
                $referrer->user_id      = $user->id;
                $referrer->upline_id    = $upline->id;
                $referrer->save();
            }

            $this->send_auth_email($verification_code, $request->register_email, 'New User', 'verify');

            // FORGET SESSION FIRST
            session()->forget('verification_register_id');
            // THEN SET SESSION
            session()->put('verification_register_id', $user->id);

            // AUTO LOGIN AFTER REGISTER
            // Auth::login($user);

            // Auth::login($user);
            return back()->with('success', $this->data['trans']['register_success']);
        }
    }

    public function forgotPasswordIndex()
    {
        $tutorial = Content::where('type', 'forgot_password');

        $this->data['tutorial']  = $this->cacheQuery('forgot_tutorial', $tutorial, 'first');

        return $this->renderView('frontend.login.forgot');
    }

    public function forgotPassword(Request $request, PasswordBroker $passwords)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'forgot_email'  => 'required',
            ],
            [
                'forgot_email.required' => $this->data['trans']['forgot_email_required'],
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            $user = User::where('email', $request->forgot_email)->first();

            // check data
            if ($user) {
                $verification_code = rand(111111, 999999);

                // send email to verification
                $this->send_auth_email($verification_code, $user->email, $user->name, 'reset');

                $user->verification_code = $verification_code;
                $user->save();

                return back()->with('success', $this->data['trans']['forgot_email_success']);
            }

            return back()->with('error', $this->data['trans']['forgot_email_failed']);
        }

        return back()->with('error', 'No Data');
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'token'                 => 'required',
                'email'                 => 'required|email|exists:users,email',
                'password'              => 'required|confirmed|min:8',
                'password_confirmation' => 'required|min:8'
            ],
            [
                'token'                 => 'Url sudah tidak berlaku. Silahkan lakukan reset password kembali.',
                'email.required'        => 'Email wajib di isi',
                'email.exists'          => 'Email tidak ada didalam database, mohon cek kembali alamat email anda.',
                'password.required'     => 'Password wajib di isi',
                'password.confirmed'    => 'Konfirmasi password tidak sama, mohon isi kembali password anda dengan sama',
                'password.min'          => 'Password harus minimal 8 huruf (alphanumeric) atau lebih',
                'password_confirmation' => 'Konfirmasi Password wajib di isi'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->messages()]);
        } else {
            $token = \DB::table('password_resets')->where('email', $request->email)->first();
            if (Hash::check($request->token, $token->token)) {
                $user = User::where('email', $request->email)->first();
                if (!$user) {
                    return back()->withErrors($validator)->withInput();
                } else {
                    $user->password = bcrypt($request->password);
                    $user->setRememberToken(Str::random(60));
                    $user->save();

                    \DB::table('password_resets')->where('email', $request->email)->delete();
                    event(new PasswordReset($user));

                    $this->setCookiesDuration();

                    Auth::guard()->login($user);

                    Session::flash('success', 'Password Berhasil Dirubah');

                    return redirect()->route('frontend.home');
                }
            } else {
                Session::flash('error', 'Url sudah tidak berlaku. Silahkan lakukan reset password kembali.');

                return back()->withErrors($validator)->withInput();
            }
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect('/');
    }

    // SOCIALITE AUTH

    // FACEBOOK
    public function redirect_to_facebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handle_facebook_callback(Request $request)
    {
        $error_code = $request->error_code;
        if ($error_code == 200) {
            return redirect()->route('frontend.home');
        }

        $user_socialite = Socialite::driver('facebook')->stateless()->user();

        $user = User::where('register_id', $user_socialite->id)->first();

        $provider = 'Facebook';

        // CHECK IF USER LOGIN USING SOCMED EXIST
        if (!$user) {
            // CHECK IF USER EMAIL ALREADY EXIST
            $userExist = User::where('email', $user_socialite->email)->first();
            if (!$userExist) {
                $insertUser = $this->saveUserToTable($provider, $user_socialite);
                $this->setCookiesDuration();
                Auth::login($insertUser);

                return redirect()->route('frontend.home');
            } else {
                $this->setCookiesDuration();
                Auth::login($userExist);

                return redirect()->route('frontend.home');
            }
        } else {
            if ($user->deleted_at) {
                $user->forceDelete();
                $user = $this->saveUserToTable($provider, $user_socialite);
            }
            $this->setCookiesDuration();
            Auth::login($user);

            return redirect()->route('frontend.home');
        }
    }

    // GOOGLE
    public function redirect_to_google()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handle_google_callback(Request $request)
    {
        if (!$request->has('code') || $request->has('denied')) {
            return back();
        } else {
            $user_socialite = Socialite::driver('google')->stateless()->user();

            $user = User::where('register_id', $user_socialite->id)->first();

            $provider = 'Google';

            if (!$user) {
                $userExist = User::where('email', $user_socialite->email)->first();
                if (!$userExist) {
                    $insertUser = $this->saveUserToTable($provider, $user_socialite);
                    $this->setCookiesDuration();
                    Auth::login($insertUser);

                    return redirect()->route('frontend.home');
                } else {
                    $this->setCookiesDuration();
                    Auth::login($userExist);

                    return redirect()->route('frontend.home');
                }
            } else {
                if ($user->deleted_at) {
                    $user->forceDelete();
                    $user = $this->saveUserToTable($provider, $user_socialite);
                }
                $this->setCookiesDuration();
                Auth::login($user);

                return redirect()->route('frontend.home');
            }
        }
    }

    public function redirect_to_linkedin()
    {
        return Socialite::driver('linkedin')->redirect();
    }

    public function handle_linkedin_callback(Request $request)
    {
        if (!$request->has('code') || $request->has('denied')) {
            return back();
        } else {
            $user_socialite = Socialite::driver('linkedin')->stateless()->user();

            $user = User::where('register_id', $user_socialite->id)->first();

            $provider = 'Linkedin';

            if (!$user) {
                $userExist = User::where('email', $user_socialite->email)->first();
                if (!$userExist) {
                    $insertUser = $this->saveUserToTable($provider, $user_socialite);
                    $this->setCookiesDuration();
                    Auth::login($insertUser);

                    return redirect()->route('frontend.home');
                } else {
                    $this->setCookiesDuration();
                    Auth::login($userExist);

                    return redirect()->route('frontend.home');
                }
            } else {
                if ($user->deleted_at) {
                    $user->forceDelete();
                    $user = $this->saveUserToTable($provider, $user_socialite);
                }
                $this->setCookiesDuration();
                Auth::login($user);

                return redirect()->route('frontend.home');
            }
        }
    }

    public function redirect_to_twitter()
    {
        return Socialite::driver('twitter')->redirect();
    }

    public function handle_twitter_callback(Request $request)
    {
        $user_socialite = Socialite::driver('twitter')->user();

        $user = User::where('register_id', $user_socialite->id)->first();

        $provider = 'Twitter';

        if (!$user) {
            $userExist = User::where('email', $user_socialite->email)->first();
            if (!$userExist) {
                $insertUser = $this->saveUserToTable($provider, $user_socialite);
                $this->setCookiesDuration();
                Auth::login($insertUser);

                return redirect()->route('frontend.home');
            } else {
                $this->setCookiesDuration();
                Auth::login($userExist);

                return redirect()->route('frontend.home');
            }
        } else {
            if ($user->deleted_at) {
                $user->forceDelete();
                $user = $this->saveUserToTable($provider, $user_socialite);
            }
            $this->setCookiesDuration();
            Auth::login($user);

            return redirect()->route('frontend.home');
        }
    }

    private function saveUserToTable($provider, $user_socialite)
    {
        $insertUser = User::create([
            'provider'                => $provider,
            'register_id'             => $user_socialite->id,
            'name'                    => $user_socialite->name,
            'nickname'                => $user_socialite->nickname,
            'email'                   => $user_socialite->email,
            'password'                => '',
            'verification_code'       => '',
            'verification_status'     => 1,
            'socialite_token'         => $user_socialite->token,
            'socialite_refresh_token' => $user_socialite->refreshToken,
            'socialite_expires_in'    => $user_socialite->expiresIn,
            'socialite_avatar'        => $user_socialite->avatar,
            'is_subscribe'            => true
        ]);

        return $insertUser;
    }

    private function send_auth_email($verification_code, $email, $name, $type)
    {
        $data = [
            'verification_code' => $verification_code,
            'email'             => $email,
            'title'             => $type == 'verify' ? 'Email Verification' : 'Forgot Password',
            'name'              => $name,
            'type'              => $type
        ];

        // send email
        if ($type == 'verify') {
            Mail::send('email.auth.email-verification', $data, function ($message) use ($email, $name) {
                $message->to($email, $name)->subject('The Tropical Spa: Email Verification');
            });
        } else {
            Mail::send('email.auth.email-verification', $data, function ($message) use ($email, $name) {
                $message->to($email, $name)->subject('The Tropical Spa: Forgot Password');
            });
        }
    }

    public function verification_code(Request $request)
    {
        // validation
        $request->validate([
            'code'              => 'required',
            'register_id'       => 'required',
            'type'              => 'required'
        ]);

        $codes = implode('', $request->code);

        // get data
        $user = User::where('id', $request->register_id)->first();

        // check data
        if ($user) {
            if ($request->type == 1) {
                if ($user->verification_code == $codes) {
                    // save data
                    $user->verification_status = true;
                    $user->save();

                    $this->setCookiesDuration();
                    Auth::login($user);

                    return response()->json(['status' => true, 'message' => 'Verification success.', 'type' => 'register']);
                } else {
                    // redirect back when verification code doesn't match
                    return response()->json(['status' => false, 'message' => 'Wrong Code, Please retry.']);
                }
            } else {
                if ($user->verification_code == $codes) {
                    // save data

                    session()->put('reset_password_user_id', $user->id);
                    session()->put('allow_reset_password', true);

                    return response()->json(['status' => true, 'message' => 'Verification success.', 'type' => 'forgot', 'id' => $user->id]);
                } else {
                    // redirect back when verification code doesn't match
                    return response()->json(['status' => false, 'message' => 'Wrong Code, Please retry.']);
                }
            }
        } else {
            session()->forget('verification_register_id');

            return response()->json(['status' => false, 'message' => 'No data']);
        }
    }

    public function reset_password_save(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'password'              => 'required|confirmed|min:8',
                'password_confirmation' => 'required|min:8'
            ],
            [
                'password.required'     => 'Password wajib di isi',
                'password.confirmed'    => 'Konfirmasi password tidak sama, mohon isi kembali password anda dengan sama',
                'password.min'          => 'Password harus minimal 8 huruf (alphanumeric) atau lebih',
                'password_confirmation' => 'Konfirmasi Password wajib di isi'
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            if (session()->get('allow_reset_password')) {
                $user = User::where('verification_code', decrypt(session()->get('allow_reset_password')))->first();
                if ($user) {
                    $user->password          = bcrypt($request->password);
                    $user->verification_code = '';
                    $user->save();

                    session()->forget('allow_reset_password');

                    Session::flash('success', 'Password successfully updated');

                    $this->setCookiesDuration();
                    Auth::login($user);

                    return redirect()->route('frontend.home');
                } else {
                    return back()->with('error', 'No Data');
                }
            } else {
                return back()->with('error', 'No Permission');
            }
        }
    }

    public function verification_resend(Request $request)
    {
        $id = session()->get('verification_register_id');
        if ($id) {
            $user = User::where('id', session()->get('verification_register_id'))->first();
            if ($user) {
                // GENERATE NEW CODE
                $verification_code       = rand(111111, 999999);
                $user->verification_code = $verification_code;
                $user->save();

                // THEN SEND EMAIL THE NEW CODE
                if ($request->type == 'register') {
                    $this->send_auth_email($user->verification_code, $user->email, $user->name, 'verify');
                } else {
                    $this->send_auth_email($user->verification_code, $user->email, $user->name, 'reset');
                }

                return response()->json(['status' => true, 'message' => 'Verification code has been resend, please check your email inbox']);
            }
        }

        return response()->json(['status' => false, 'message' => 'No Permission']);
    }

    public function verification($hash)
    {
        $code = decrypt($hash);
        $user = User::where('verification_code', $code)->firstOrFail();
        if ($user) {
            $user->verification_status = 1;
            $user->save();

            $this->setCookiesDuration();
            Auth::login($user);

            return redirect()->route('frontend.home')->with('success', 'Thank you, your account has been verified.');
        } else {
            return redirect()->route('frontend.home')->with('error', 'Failed to verify please retry');
        }
    }

    public function forgotPasswordVerification($hash)
    {
        $code = decrypt($hash);
        $user = User::where('verification_code', $code)->first();

        if ($user) {
            session()->put('allow_reset_password', $hash);

            return $this->renderView('frontend.login.reset');
        } else {
            return redirect()->route('frontend.home')->with('error', $this->data['trans']['reset_password_expired']);
        }
    }

    private function setCookiesDuration()
    {
        $expires = time() + 60 * 60 * 24 * 7;
        \Session::put('cookie_expires', $expires);

        return true;
    }
}
