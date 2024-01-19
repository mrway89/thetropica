<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductReviewImage extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function review()
    {
        return $this->belongsTo(ProductReview::class, 'product_review_id');
    }
}
