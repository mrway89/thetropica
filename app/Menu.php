<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public function getNameAttribute()
    {
        $locale = \App::getLocale();
        $column = 'name_' . $locale;
        return $this->{$column};
    }
}
