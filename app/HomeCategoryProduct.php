<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomeCategoryProduct extends Model
{
    protected $table = 'home_category_product';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
