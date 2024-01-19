<?php

namespace App;

use App\Events\Reward;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'title',
        'username',
        'dob',
        'age',
        'gender',
        'avatar',
        'remember_token',
        'is_provider',

        'provider',
        'register_id',

        'password',
        'verification_code',
        'verification_status',
        'socialite_token',

        'socialite_refresh_token',
        'socialite_expires_in',
        'socialite_avatar',
        'is_subscribe',
        'company_name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function addressDefault()
    {
        return $this->hasOne(UserAddress::class, 'user_id', 'id')->where('is_default', 1);
    }

    public function getAvatarAttribute($value)
    {
        if (!$value) {
            if ($this->socialite_avatar) {
                return $this->socialite_avatar;
            } else {
                return asset('assets/img/default_avatar.jpg');
            }
        } else {
            return asset($value);
        }
    }

    public function getGenderAttribute($value)
    {
        return ucfirst($value);
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function userWishlisted($id)
    {
        $product = $this->wishlist()->where('product_id', $id)->first();

        if ($product) {
            return true;
        }

        return false;
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function orderCheck($id)
    {
        return $this->orders->where('id', $id)->first();
    }

    public function reviews()
    {
        return $this->orders->where('status', 'completed');
    }

    public function provider()
    {
        return $this->hasMany(UserServiceProvider::class);
    }

    public function rewardPercentage()
    {
        $summary = \App\Order::with('user')->where('user_id', \Auth::id())
            ->select(\DB::raw('sum(grand_total) as total_order'))
            ->where('status', 'completed')->first();

        if (!is_null($summary->total_order)) {
            $level = \App\Reward::where('buy_from', '<', $summary->total_order)->where('buy_to', '>', $summary->total_order)->first();
        } else {
            $level = \App\Reward::find(1);
        }

        return $level->percentage * 10000;
    }

    public function credit()
    {
        return $this->hasMany(UserReward::class);
    }

    public function creditBalance()
    {
        $income  = \App\UserReward::where('user_id', \Auth::id())->where('type', 'in')->sum('points');
        $expense = \App\UserReward::where('user_id', \Auth::id())->where('type', 'out')->sum('points');

        return $income - $expense;
    }

    public function rewardLevel()
    {
        $summary     = \App\Order::with('user')->where('user_id', \Auth::id())
            ->select(\DB::raw('sum(grand_total) as total_order'))
            ->where('status', 'completed')->first();

        if ($summary->total_order) {
            $total = $summary->total_order;
        } else {
            $total = 0;
        }

        $level = \App\Reward::where('buy_from', '<', $total)->where('buy_to', '>', $total)->first();

        return $level->name;
    }

    public function userCart()
    {
        return $this->hasOne(Cart::class, 'user_id', 'id')->where('status', 'current')->where('type', 'cart')->first();
    }

    public function coupons()
    {
        return $this->hasMany(UserCoupon::class)->orderBy('created_at', 'DESC');
    }

    public function referralCode()
    {
        $name = substr($this->name, 0, 5);

        $name = trim($name, ' ');
        $ref  = $name . $this->id;

        return $ref;
    }

    public function referrer()
    {
        return $this->hasOne(UserReferral::class, 'user_id', 'id');
    }

    public function hasReferrer()
    {
        if ($this->referrer->upline->id) {
            return true;
        }

        return false;
    }

    public function processReferrer($order)
    {
        if ($order->isFirstBuy()) {
            if ($this->referrer->upline->is_reseller == 1) {
                $cashback                   = Config::where('name', 'reseller_percentage')->first();
            } else {
                $cashback                   = Config::where('name', 'referrer_percentage')->first();
            }

            $referrerCashback           = new UserReward;
            $referrerCashback->user_id  = $this->referrer->upline->id;
            $referrerCashback->type     = 'in';
            $referrerCashback->note     = 'Referrer reward dari pembelian ' . $this->name;
            $referrerCashback->points   = ceil(($cashback->value / 100) * $order->grand_total);
            $referrerCashback->save();
            event(new Reward($referrerCashback));

            $cashback                   = Config::where('name', 'referee_percentage')->first();
            $referrerCashback           = new UserReward;
            $referrerCashback->user_id  = $this->id;
            $referrerCashback->type     = 'in';
            $referrerCashback->note     = 'Referee reward dari pembelian ' . $order->order_code;
            $referrerCashback->points   = ceil(($cashback->value / 100) * $order->grand_total);
            $referrerCashback->save();
            event(new Reward($referrerCashback));
        } else {
            if ($this->referrer->upline->isReseller()) {
                $cashback                   = Config::where('name', 'reseller_percentage')->first();

                $referrerCashback           = new UserReward;
                $referrerCashback->user_id  = $this->referrer->upline->id;
                $referrerCashback->type     = 'in';
                $referrerCashback->note     = 'Reseller reward dari pembelian ' . $this->name;
                $referrerCashback->points   = ceil(($cashback->value / 100) * $order->grand_total);
                $referrerCashback->save();
                event(new Reward($referrerCashback));
            }
        }

        return;
    }

    public function hasRewardNotification()
    {
        $checkNotif = \App\UserRewardNotification::where('user_id', $this->id)->where('is_read', 0)->first();

        if ($checkNotif) {
            return true;
        }

        return false;
    }

    public function isReseller()
    {
        if ($this->is_reseller == 1) {
            return true;
        }

        return false;
    }
}
