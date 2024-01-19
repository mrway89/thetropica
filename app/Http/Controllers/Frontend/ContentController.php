<?php

namespace App\Http\Controllers\Frontend;

use App\Category;
use App\Content;
use App\Image;
use App\Newsletter;
use App\Origin;
use App\Post;
use App\Product;
use App\ProductReview;
use App\ProductReviewImage;
use DB;
use function GuzzleHttp\json_decode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Mail;

class ContentController extends CoreController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function aboutUs()
    {
        $posts                    = Image::where('type', 'about_slides')->orderBy('sorting', 'ASC');
        $contact                  = Content::where('type', 'contact_us')->first();
        $bgContact                = Image::where('type', 'about_background')->where('title_id', 'Contact')->first();
        $bgPost                   = Image::where('type', 'about_background')->where('title_id', 'Social Program')->first();
        $news                     = Post::with('images')->where('type', 'news')->orderBy('created_at', 'desc')->get();

        $countries = DB::table('loc_countries')->orderBy('name', 'asc');
        $cities    = DB::table('loc_states')->where('country_id', 102)->orderBy('name', 'asc');

        $other                    = null;

        if ($contact->other_content) {
            $other                = json_decode($contact->other_content);
        }

        $this->data['contact']      = $contact;
        $this->data['other']        = $other;
        $this->data['bgContact']    = $bgContact;
        $this->data['bgPost']       = $bgPost;

        $this->data['news']         = $news;
        $this->data['posts']        = $this->cacheQuery('about_slides', $posts, 'get');
        $this->data['countries']    = $this->cacheQuery('countries', $countries, 'get');
        $this->data['cities']       = $this->cacheQuery('cities', $cities, 'get');

        // SEO
        $this->data['head_title']            = $this->data['about_title'];
        $this->data['head_meta_title']       = $this->data['about_meta_title'];
        $this->data['head_description']      = $this->data['about_description'];
        $this->data['head_keyword']          = $this->data['about_keywords'];

        return $this->renderView('frontend.about');
    }

   public function contactUs(){
		$posts                    = Image::where('type', 'about_slides')->orderBy('sorting', 'ASC');
        $contact                  = Content::where('type', 'contact_us')->first();
        $bgContact                = Image::where('type', 'about_background')->where('title_id', 'Contact')->first();
        $bgPost                   = Image::where('type', 'about_background')->where('title_id', 'Social Program')->first();
        $news                     = Post::with('images')->where('type', 'news')->orderBy('created_at', 'desc')->get();

        $countries = DB::table('loc_countries')->orderBy('name', 'asc');
        $cities    = DB::table('loc_states')->where('country_id', 102)->orderBy('name', 'asc');

        $other                    = null;

        if ($contact->other_content) {
            $other                = json_decode($contact->other_content);
        }

        $this->data['contact']      = $contact;
        $this->data['other']        = $other;
        $this->data['bgContact']    = $bgContact;
        $this->data['bgPost']       = $bgPost;

        $this->data['news']         = $news;
        $this->data['posts']        = $this->cacheQuery('about_slides', $posts, 'get');
        $this->data['countries']    = $this->cacheQuery('countries', $countries, 'get');
        $this->data['cities']       = $this->cacheQuery('cities', $cities, 'get');

        // SEO
        $this->data['head_title']            = $this->data['about_title'];
        $this->data['head_meta_title']       = $this->data['about_meta_title'];
        $this->data['head_description']      = $this->data['about_description'];
        $this->data['head_keyword']          = $this->data['about_keywords'];

        return $this->renderView('frontend.contactv');
	} 

    public function contactPost(Request $request)
    {
        $request->validate([
            'name'                       => 'required|string',
            'email'                      => 'required|email',
            'country'                    => 'required',
            'city'                       => 'required|string',
            'comment'                    => 'required|string',
            'recaptcha'                  => 'required'
        ]);

        $recaptcha_url      = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_secret   = env('RECAPTCHAV3_SECRET');
        $recaptcha_response = $request->recaptcha;

        $recaptcha = $recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response;

        $client  = new \GuzzleHttp\Client();
        $res     = $client->get($recaptcha);
        $content = (string) $res->getBody();

        $recaptcha = json_decode($content);

        if ($recaptcha->score >= 0.5) {
            $name  = $request->name;

            $email = $request->email;

            $city    = DB::table('loc_states')->where('id', $request->city)->select(['name'])->first();
            $country = DB::table('loc_countries')->where('id', $request->country)->select(['name'])->first();

            $data = [
                'email'              => $email,
                'name'               => $name,
                'content'            => $request->comment,
                'phone'              => $request->phone,
                'address'            => $request->address,
                'company'            => $request->company,
                'city'               => $city->name,
                'country'            => $country->name,
                'fax'                => $request->fax,
                'title'              => 'New Contact Message',
            ];

            $adminEmail  = $this->getAdminEmails();
            $firstEmail  = array_splice($adminEmail, 0, 1);

            Mail::send('email.contact.user', $data, function ($message) use ($email, $name) {
                $message->to($email, $name)->subject('Talasi: Contact Message Sent');
            });

            Mail::send('email.contact.admin', $data, function ($message) use ($firstEmail, $adminEmail) {
                $message->to($firstEmail, 'Admin')->bcc($adminEmail)->subject('Talasi: You Have New Contact Message');
            });

            return redirect()->back()->with('success', 'Thank You, Your message has been sent.');
        } else {
            \Session::flash('error', 'recaptcha failed, please retry');

            return redirect()->back()->withInput();
        }
    }

    public function ajaxCountryCity(Request $request)
    {
        if ($request->country) {
            $cities = DB::table('loc_states')->where('country_id', $request->country)->orderBy('name', 'ASC')->get();

            return response()->json(['status' => true, 'cities' => $cities]);
        }

        return response()->json(['status' => false]);
    }

    public function faqs()
    {
        $posts               = Content::where('type', 'faqs')->orderBy('sorting', 'ASC')->get();
        // $this->data['post']  = $post;
        $this->data['posts'] = $posts;

        return $this->renderView('frontend.pages.purchase.faq');
    }

    public function privacyPolicy()
    {
        $post                = Content::where('type', 'privacy_policy')->first();
        $this->data['post']  = $post;

        return $this->renderView('frontend.pages.abouts.privacy_policy');
    }

    public function userAgreement()
    {
        $post                = Content::where('type', 'user_agreement')->first();
        $this->data['post']  = $post;

        return $this->renderView('frontend.pages.user_agreement');
    }

    public function termsConditions()
    {
        $post                = Content::where('type', 'terms_conditions')->first();
        $this->data['post']  = $post;

        return $this->renderView('frontend.pages.abouts.terms_conditions');
    }

    public function shoppingGuide()
    {
        $posts               = Content::where('type', 'shopping_guide')->orderBy('sorting', 'ASC')->get();
        // $this->data['post']  = $post;
        $this->data['posts'] = $posts;

        return $this->renderView('frontend.purchase.payment_guide');
    }

    public function paymentGuide()
    {
        $posts               = Content::where('type', 'payment_guide')->orderBy('sorting', 'ASC')->get();
        // $this->data['post']  = $post;
        $this->data['posts'] = $posts;

        return $this->renderView('frontend.purchase.payment_guide');
    }

    public function howtoPage($slug)
    {
        $post                = Content::where('type', 'how_to')->where('slug', $slug)->first();
        $posts               = Content::where('type', 'how_to')->orderBy('sorting', 'ASC')->get();
        $this->data['post']  = $post;
        $this->data['posts'] = $posts;

        return $this->renderView('frontend.pages.abouts.help');
    }

   /*public function contactUs()
    {
        $post                 = Content::where('type', 'contact_us')->first();
        $other                = null;
        if ($post->other_content) {
            $other                = json_decode($post->other_content);
        }

        $this->data['post']  = $post;
        $this->data['other'] = $other;

        return $this->renderView('frontend.pages.abouts.contact_us');
    }*/

    public function newsIndex()
    {
        $posts                    = Post::with('category')->where('type', 'news')->orderBy('created_at', 'DESC')->paginate(9);
        $categories               = Category::where('type', 'news')->get();
        $this->data['posts']      = $posts;
        $this->data['categories'] = $categories;
        $this->data['active']     = 'all';

        return $this->renderView('frontend.pages.articles.news_event');
    }

    public function newsDetail($slug)
    {
        $post                      = Post::where('slug', $slug)->get();
        $categories                = Category::where('type', 'news')->get();
        $latests                   = Post::with('category')->where('type', 'news')->orderBy('created_at', 'DESC')->get()->take(4);

        $this->data['post']        = $post;
        $this->data['latests']     = $latests;

        return $this->renderView('frontend.pages.articles.news_event_detail');
    }

    public function newsCategory($slug)
    {
        $category                      = Category::where('slug', $slug)->firstOrFail();
        $posts                         = Post::with('category')->where('type', 'news')->where('category_id', $category->id)->orderBy('created_at', 'DESC')->paginate(9);
        $categories                    = Category::where('type', 'news')->get();
        $this->data['posts']           = $posts;
        $this->data['categories']      = $categories;
        $this->data['active']          = $category->slug;
        $this->data['active_name']     = $category->title;

        return $this->renderView('frontend.pages.articles.news_event');
    }

    public function promotionList()
    {
        $posts                    = Post::where('type', 'promotion')->orderBy('created_at', 'DESC')->paginate(9);
        $this->data['posts']      = $posts;

        return $this->renderView('frontend.pages.articles.promotion_list');
    }

    public function promotionDetail($slug)
    {
        $post                     = Post::where('type', 'promotion')->where('slug', $slug)->firstOrFail();
        $related                  = Post::where('type', 'promotion')->where('id', '!=', $post->id)->take(4)->get();
        $this->data['post']       = $post;
        $this->data['related']    = $related;

        return $this->renderView('frontend.pages.articles.promotion_detail');
    }

    public function originIndex()
    {
        $origins = Origin::where('is_active', 1)->orderBy('name', 'ASC')->get();
        $content_check = [];
        foreach ($origins as $o) {
            $content_check[$o->id] = Image::where([
                ['item_id', $o->id],
                ['type', 'origin_slides']
            ])->get()->count();
        }        

        $this->data['content_check'] = $content_check;
        $this->data['origins'] = $origins;
        $this->data['content'] = Image::where('type', 'origin_map_content')->first();

        // SEO
        $this->data['head_title']       = $this->data['origin_title'];
        $this->data['head_meta_title']  = $this->data['origin_meta_title'];
        $this->data['head_description'] = $this->data['origin_description'];
        $this->data['head_keyword']     = $this->data['origin_keywords'];

        return $this->renderView('frontend.pages.origin.origin_map');
    }

    public function originDetail($slug)
    {
        $origin = Origin::where('slug', $slug)->first();
        $slides = Image::where('item_id', $origin->id)->where('type', 'origin_slides')->orderBy('sorting', 'ASC')->get();

        $this->data['slides'] = $slides;
        $this->data['origin'] = $origin;

        return $this->renderView('frontend.pages.origin.discover_origin');
    }

    public function ajaxGetProduct($slug)
    {
        $product = Product::where('slug', $slug)->first();
        if ($product) {
            $this->data['product'] = $product;
            $content               = view('frontend.includes.modals.part_modal_detail_product', $this->data)->render();

            return response()->json([
                'status'     => true,
                'content'    => $content,
            ]);
        }

        return response()->json([
            'status'     => false
        ]);
    }

    public function ajaxGetReview($id)
    {
        $decrypted                = Crypt::decryptString($id);
        $product                  = Product::with('review')->find($decrypted);
        if ($product) {
            $one     = ProductReview::where('product_id', $product->id)->where('approve', 1)->whereBetween('rating', [0, 1.99])->get()->count();
            $two     = ProductReview::where('product_id', $product->id)->where('approve', 1)->whereBetween('rating', [2, 2.99])->get()->count();
            $three   = ProductReview::where('product_id', $product->id)->where('approve', 1)->whereBetween('rating', [3, 3.99])->get()->count();
            $four    = ProductReview::where('product_id', $product->id)->where('approve', 1)->whereBetween('rating', [4, 4.99])->get()->count();
            $five    = ProductReview::where('product_id', $product->id)->where('approve', 1)->where('rating', 5)->get()->count();

            $reviews = ProductReview::where('product_id', $product->id)->where('approve', 1)->get()->count();

            $this->data['one']          = $one;
            $this->data['two']          = $two;
            $this->data['three']        = $three;
            $this->data['four']         = $four;
            $this->data['five']         = $five;
            $this->data['reviewCount']  = $reviews;

            $this->data['images']       = ProductReviewImage::whereHas('review', function ($q) {
                $q->where('approve', 1);
            })->where('product_id', $product->id)->get();

            $this->data['product']      = $product;

            $content               = view('frontend.includes.modals.part_modal_reviews', $this->data)->render();

            return response()->json([
                'status'     => true,
                'content'    => $content,
            ]);
        }

        return response()->json([
            'status'     => false
        ]);
    }

    public function ajaxGetReviewImage($id)
    {
        $decrypted                = Crypt::decryptString($id);
        $images                   = ProductReviewImage::with('user', 'review')->where('product_review_id', $decrypted)->get();
        if ($images) {
            $this->data['images']  = $images;
            $content               = view('frontend.includes.modals.part_modal_reviews_image', $this->data)->render();

            return response()->json([
                'status'     => true,
                'content'    => $content,
            ]);
        }

        return response()->json([
            'status'     => false
        ]);
    }

    public function test()
    {
        return $this->renderView('frontend.test');
    }

    public function ajaxCompareProduct(Request $request)
    {
        $products           = Product::where('category_id', $request->category)->orderBy('origin_id', 'ASC')->where('is_active', 1)->get();
        $options            = '<option>Select Product</option>';
        foreach ($products as $product) {
            $options .= '<option value="' . $product->id . '">' . ucwords($product->name) . ' (' . $product->origin->village . ') ' . $product->product_weight . ' ' . $product->unit . '</option>';
        }
        $data['status']     = true;
        $data['products']   = $options;

        session()->forget('category_compare');

        $sess = [
            'category'    => $request->category,
        ];

        session()->put('category_compare', $sess);

        return response()->json($data);
    }

    public function ajaxCompareProductDetail(Request $request)
    {
        $category = session()->get('category_compare');

        $item                   = Product::find($request->product);
        $product['select']      = $request->select;
        $product['detail']      = $item;
        $product['language']    = session()->get('locale');
        $product['products']    = Product::where('category_id', $category['category'])->get();
        $view                   = view('frontend.purchase.includes.part_product_compare', $product)->render();
        $data['status']         = true;
        $data['products']       = $options;
        $data['view']           = $view;
        $dataSession            = [
            'product'    => $item,
        ];
        session()->forget('compare_' . $request->select);

        session()->put('compare_' . $request->select, $dataSession);

        return response()->json($data);
    }

    public function ajaxCompareProductRemove(Request $request)
    {
        session()->forget('compare_' . $request->id);

        return response()->json(['status' => true]);
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $checkEmail = Newsletter::where('email', $request->email)->first();

        if ($checkEmail) {
            return redirect()->back()->with('error', 'Already Subscriber');
        } else {
            $subscribe        = new Newsletter;
            $subscribe->email = $request->email;
            $subscribe->save();

            return redirect()->back()->with('success', 'Thank you for subscribing to our newsletter');
        }
    }

    public function staticContent($slug)
    {
        $content =  Post::where('type', 'static_content')->where('slug', $slug)->first();
        if ($content) {
            $this->data['post']  = $content;

            return $this->renderView('frontend.pages.user_agreement');
        } else {
            abort(404);
        }
    }

    public function midtes(){
		require_once dirname(__FILE__) . '/midtrans/midtrans-php/Midtrans.php'; 

		// Set your Merchant Server Key
		\Midtrans\Config::$serverKey = 'SB-Mid-server-XdJony36hI9wqrhYXHO0OxFO';
		// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
		\Midtrans\Config::$isProduction = false;
		// Set sanitization on (default)
		\Midtrans\Config::$isSanitized = true;
		// Set 3DS transaction for credit card to true
		\Midtrans\Config::$is3ds = true;

		$params = array(
			'transaction_details' => array(
				'order_id' => rand(),
				'gross_amount' => 10000,
			),
			'customer_details' => array(
				'first_name' => 'budi',
				'last_name' => 'pratama',
				'email' => 'budi.pra@example.com',
				'phone' => '08111222333',
			),
		);

		$snapToken = \Midtrans\Snap::getSnapToken($params);
		
		print_r($snapToken);
	}
}
