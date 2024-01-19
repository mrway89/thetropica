<?php

namespace App\Http\Controllers\Frontend;

use App\ExperienceContent;

class ExperienceController extends CoreController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function experienceIndex()
    {
        $experience                 = ExperienceContent::where('type', 'index')->first();
        $this->data['experience']   = $experience;
        $experiences                = ExperienceContent::where('type', 'experience_list')->get();
        $this->data['experiences']  = $experiences;

        // SEO
        $this->data['head_title']       = $this->data['experience_title'];
        $this->data['head_meta_title']  = $this->data['experience_meta_title'];
        $this->data['head_description'] = $this->data['experience_description'];
        $this->data['head_keyword']     = $this->data['experience_keywords'];

        return $this->renderView('frontend.experience.experience_index');
    }

    public function experienceList()
    {
        $experiences                = ExperienceContent::where('type', 'experience_list')->get();
        $this->data['experiences']  = $experiences;

        return $this->renderView('frontend.experience.list_experience');
    }

    public function experienceDetail($slug)
    {
        $parent                     = ExperienceContent::where('slug', $slug)->first();
        $experiences                = ExperienceContent::where('type', $parent->id)->get();
        $this->data['experiences']  = $experiences;

        return $this->renderView('frontend.experience.list_experience');
    }

    public function experienceRetreat()
    {
        $parent                 = ExperienceContent::where('slug', 'retreat')->first();
        $this->data['contents'] = ExperienceContent::where('parent_id', $parent->id)->get();

        return $this->renderView('frontend.experience.retreat');
    }

    public function experienceRetreatDetail($slug)
    {
        $parent                  = ExperienceContent::where('type', 'retreat')->where('slug', $slug)->first();
        $this->data['content']   = ExperienceContent::where('type', 'retreat_detail')->where('subparent_id', $parent->id)->first();

        return $this->renderView('frontend.experience.detail_retreat');
    }

    public function experienceFactory()
    {
        $parent                 = ExperienceContent::where('slug', 'factory-visit')->first();
        $this->data['contents'] = ExperienceContent::where('parent_id', $parent->id)->get();

        return $this->renderView('frontend.experience.factory_visit');
    }

    public function experienceCamps()
    {
        $parent                 = ExperienceContent::where('slug', 'camp-with-us')->first();
        $this->data['contents'] = ExperienceContent::where('type', 'camps')->where('parent_id', $parent->id)->get();
        $this->data['item']     = ExperienceContent::where('type', 'camp_content')->first();

        return $this->renderView('frontend.experience.camp_us');
    }

    public function experienceCampsDetail($slug)
    {
        $parent                  = ExperienceContent::where('type', 'camps')->where('slug', $slug)->first();
        $this->data['contents']  = ExperienceContent::where('subparent_id', $parent->id)->get();

        return $this->renderView('frontend.experience.camp_us_list');
    }
}
