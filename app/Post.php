<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function scopeSearch($query, $keywords)
    {
        return $query->where('title', 'LIKE', '%' . $keywords . '%');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'item_id', 'id')->where('type', 'news')->orderBy('sorting', 'asc');
    }
}
