<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class, 'item_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'item_id');
    }
}
