<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExperienceContent extends Model
{
    public function getLinkAttribute($value)
    {
        $link = '';
        if ($this->slug == 'retreat') {
            $link = route('frontend.experience.retreat');
        }
        if ($this->slug == 'factory-visit') {
            $link = route('frontend.experience.factory');
        }
        if ($this->slug == 'camp-with-us') {
            $link = route('frontend.experience.camps');
        }

        return $link;
    }
}
