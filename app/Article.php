<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public function singleProduct()
    {
        return $this->belongsToMany(Product::class, 'article_single_product', 'id_articles', 'id_products');
    }

    public function topTenProduct()
    {
        return $this->belongsToMany(Product::class, 'article_topten_product', 'id_articles', 'id_products');
    }

    public function videoProduct()
    {
        return $this->belongsToMany(Product::class, 'article_video_product', 'id_articles', 'id_products');
    }

    public function reviewProduct()
    {
        return $this->belongsToMany(Product::class, 'article_review_product', 'id_articles', 'id_products');
    }
}
