<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Origin extends Model
{
    public function images()
    {
        return $this->hasMany(Image::class, 'item_id', 'id')->where('type', 'origin_slides');
    }

    public function getVillageAttribute($value)
    {
        $name = explode(',',  $this->name);
        return $name[0];
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'origin_id', 'id');
    }

    public function bottom()
    {
        return $this->hasOne(Image::class, 'item_id', 'id')->where('type', 'origin_product_image');
    }
}
