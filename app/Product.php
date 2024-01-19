<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;

class Product extends Model
{
    protected $guarded = [];
    protected $appends = ['full_name', 'display_name'];

    public function cover()
    {
        return $this->hasOne(Image::class, 'item_id', 'id')->where('type', 'product')->where('is_featured', 1);
    }

    public function getFullNameAttribute($value)
    {
        $name = $this->name . ' ' . $this->product_weight . ' ' . $this->unit;

        return $name;
    }

    public function getDisplayNameAttribute($value)
    {
        $name = '';
        $name .= '<b>' . $this->category->title_en . '</b><br>';
        $name .= '<b>' . $this->origin->village . '</b><br>';
        $name .= '<b>' . $this->product_weight . ' ' . $this->unit . '</b><br>';

        return $name;
    }

    public function getCoverPathAttribute($value)
    {
        $path = $this->cover->url;

        return $path;
    }

    public function otherProducts()
    {
        return $this->hasMany(ProductRelated::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'item_id', 'id')->where('type', 'product')->where('is_featured', 0)->orderBy('sorting', 'asc');
    }

    public function certifications()
    {
        return $this->hasMany(Image::class, 'item_id', 'id')->where('type', 'product_certification');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function origin()
    {
        return $this->belongsTo(Origin::class);
    }

    public function brand()
    {
        return $this->belongsTo(ProductBrand::class);
    }

    public function Ticket()
    {
        return $this->belongsTo(EventScheduleGroupTicket::class, 'id_ticket', 'id_ticket');
    }

    public function getSpecificationAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getFeaturesAttribute($value)
    {
        $parts  = explode(',', $value);
        $result = implode(', ', $parts);

        return ucwords($result);
    }

    public function hasStock()
    {
        $stock  = $this->attributes['stock'];

        if ($stock > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function homeCategory()
    {
        return $this->belongsToMany('App\Category', 'home_category_product', 'product_id', 'category_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function getUserCanReview($userId)
    {
        $existProduct = self::where('id', $this->id)
            ->whereHas('orderDetails', function ($orderDetails) use ($userId) {
                $orderDetails->whereHas('order', function ($order) use ($userId) {
                    $order->where('user_id', $userId)->where('status', 'Completed');
                });
            })->exists();

        $existReview = self::where('id', $this->id)
            ->whereHas('review', function ($review) use ($userId) {
                $review->where('user_id', $userId);
            })->exists();

        if ($existProduct === true && $existReview === false) {
            return true;
        } else {
            return false;
        }
    }

    public function getShortDescription()
    {
        return $this->description ? str_limit($this->description, 73, '...') : '';
    }

    public function isDiscount()
    {
        if ($this->discounted_price) {
            if ($this->discounted_price > 0) {
                return true;
            }
        }

        return false;
    }

    public function getPrice()
    {
        if ($this->discounted_price) {
            return $this->discounted_price;
        }

        return $this->price;
    }

    public function getPriceCurrentAttribute()
    {
        if ($this->discounted_price) {
            return $this->discounted_price;
        }

        return $this->price;
    }

    public function review()
    {
        return $this->hasMany(ProductReview::class)->where('approve', 1);
    }

    public function getReview($id)
    {
        return $this->reviews->where('user_id', $id)->first();
    }

    public function scopeSearch($query, $params)
    {
        if ($params) {
            $this->fill($params);
            if (Arr::exists($params, 'search') && $params['search'] != '') {
                $search =  $params['search'];
                $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('tags', 'LIKE', '%' . $search . '%');
            }
        }

        return $query;
    }

    public function scopeFilterProduct($q)
    {
        if (request('price')) {
            $price                    = explode(',', request('price'));
            $pricebot                 = $price[0];
            $pricetop                 = $price[1];
            if ($price[0] > 0 && $price[1] > 0) {
                $q->where(function ($query) use ($pricebot, $pricetop) {
                    $query->wherebetween('price', [$pricebot, $pricetop])
                        ->orWhereBetween('discounted_price', [$pricebot, $pricetop]);
                });
            } else {
                if ($price[0] > 0) {
                    $q->where(function ($query) use ($pricebot) {
                        $query->where('price', '>=', $pricebot)
                            ->orWhere('discounted_price', '>=', $pricebot);
                    });
                }
                if ($price[1] > 0) {
                    $q->where(function ($query) use ($pricetop) {
                        $query->where('price', '<=', $pricetop)
                            ->orWhere('discounted_price', '<=', $pricetop);
                    });
                }
            }
        }

        if (request('sort')) {
            switch (request('sort')) {
                case '1':
                    $q->orderBy('view', 'DESC');
                    break;
                case '2':
                    $q->orderBy('origin_id', 'DESC');
                    break;
                case '3':
                    $q->orderBy('price', 'ASC');
                    break;
                case '4':
                    $q->orderBy('price', 'DESC');
                    break;
                case '5':
                    $q->orderBy('brand_name', 'ASC');
                    break;
                default:
                    $q->orderBy('updated_at', 'DESC');
                    break;
            }
        }

        if (request('brand')) {
            $brands = explode(',', request('brand'));
            $q->whereIn('brand_id', $brands);
        }

        if (request('origin')) {
            $origins = explode(',', request('origin'));
            $q->whereIn('origin_id', $origins);
        }

        if (request('keyword')) {
            $feats                         = explode(',', request('keyword'));
            foreach ($feats as $key => $element) {
                $q->where('tags', 'like', '%' . $element . '%');
            }
        }

        if (request('weight')) {
            $weight = explode('-', request('weight'));
            $q->whereBetween('product_weight', [$weight[0], $weight[1]]);
        }

        return $q;
    }

    public function encrypted()
    {
        return Crypt::encryptString($this->id);
    }
}
