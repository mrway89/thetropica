<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class ProductReview extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeBestRatingProducts($query, $params)
    {
        if (isset($params['from']) && isset($params['to'])) {
            $query->whereBetween('created_at', [$params['from'] . ' 00:00:00', $params['to'] . ' 23:59:59']);
        }

        return $query;
    }

    public function images()
    {
        return $this->hasMany(ProductReviewImage::class, 'product_review_id', 'id');
    }

    public function encrypted()
    {
        return Crypt::encryptString($this->id);
    }
}
