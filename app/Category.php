<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id')->orderBy('title', 'ASC');
    }

    public function childs()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function getTitleAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    public function menu()
    {
        return $this->hasMany(Category::class, 'parent_id')->take(2);
    }

    public function homeProducts()
    {
        return $this->hasMany(HomeCategoryProduct::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
