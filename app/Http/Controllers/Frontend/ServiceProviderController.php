<?php

namespace App\Http\Controllers\Frontend;

use App\Category;
use App\Content;
use App\UserServiceProvider;
use App\UserServiceProviderProject;
use App\UserServiceProviderQuotation;
use Illuminate\Http\Request;
use Validator;

class ServiceProviderController extends CoreController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $categories               = Category::where('type', 'service_provider_type')->orderBy('title', 'ASC')->get();
        $this->data['categories'] = $categories;

        $post                     = Content::where('type', 'service_provider')->first();
        $this->data['post']       = $post;
        $this->data['banner']     = json_decode($post->other_content);
        return $this->renderView('frontend.pages.service_provider.service_provider_category');
    }

    public function categoryList(Request $request, $slug)
    {
        $category  = Category::where('type', 'service_provider_type')->where('slug', $slug)->first();
        $providers = UserServiceProvider::
        // where('active', 1)->
        where('category_id', $category->id)->orderBy('created_at', 'ASC');

        if ($request->letter) {
            $providers = $providers->where('name', 'like', $request->letter . '%');
        }

        if ($request->search) {
            $providers = $providers->search($request->search);
        }

        $this->data['categories'] = Category::where('type', 'service_provider_type')->where('id', '!=', $category->id)->get();

        $this->data['category']   = $category;
        $this->data['providers']  = $providers->paginate(9);
        $this->data['abjad']      = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

        return $this->renderView('frontend.pages.service_provider.service_provider_list');
    }

    public function detail($category, $slug)
    {
        $provider                        = UserServiceProvider::
        // where('active', 1)->
        where('slug', $slug)->first();
        $services                        = explode(',', $provider->services);
        $this->data['services']          = $services;
        $this->data['provider']          = $provider;
        $request_projects                = UserServiceProviderProject::where('user_service_provider_id', $provider->id)->orderBy('title', 'ASC')->get();
        $this->data['related']           = UserServiceProvider::where('id', '!=', $provider->id)
        // ->where('active', 1)
        ->where('category_id', $provider->category_id)
        ->take(3)->get();
        $this->data['request_projects']  = $request_projects;
        $this->data['active']            = 'detail';

        return $this->renderView('frontend.pages.service_provider.service_provider_detail');
    }

    public function detailProjects($category, $slug)
    {
        $provider                        = UserServiceProvider::
        // where('active', 1)->
        where('slug', $slug)->first();
        $projects                        = UserServiceProviderProject::with('images', 'videos')->where('user_service_provider_id', $provider->id)->orderBy('created_at', 'DESC')->paginate(9);
        $services                        = explode(',', $provider->services);
        $request_projects                = UserServiceProviderProject::where('user_service_provider_id', $provider->id)->orderBy('title', 'ASC')->get();
        $this->data['services']          = $services;
        $this->data['provider']          = $provider;
        $this->data['projects']          = $projects;
        $this->data['related']           = UserServiceProvider::where('id', '!=', $provider->id)->where('active', 1)->where('category_id', $provider->category_id)->take(3)->get();
        $this->data['request_projects']  = $request_projects;
        $this->data['active']            = 'project';

        return $this->renderView('frontend.pages.service_provider.service_provider_project');
    }

    public function requestQuotation(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'           => 'required',
                'proposed_date'  => 'required',
                'email'          => 'required',
                'service_type'   => 'required',
                'message'        => 'required',
            ]
        );

        if ($validator->fails()) {
            $message = $validator->errors()->all();

            $message = implode('<br/>', $message);
            \Session::flash('error', $message);
            \Session::flash('error_quotation', 'ok');
            $previousUrl = app('url')->previous();
            return back()->withInput();
        } else {
            $quotation                                      = new UserServiceProviderQuotation;
            $quotation->user_service_provider_id            = $request->provid;
            $quotation->user_service_provider_project_id    = $request->service_type;
            $quotation->name                                = $request->name;
            $quotation->proposed_date                       = \Carbon\Carbon::parse($request->proposed_date);
            $quotation->email                               = $request->email;
            $quotation->phone                               = $request->phone;
            $quotation->message                             = $request->message;
            $quotation->save();

            $email = $request->email;
            $name  = $request->name;

            $data  = [
                'quotation'              => $quotation,
                'email'                  => $email,
                'name'                   => $name,
                'content'                => $request->message,
                'phone'                  => $request->phone,
                'title'                  => 'Request Quotation Sent',
            ];

            \Mail::send('email.contact.request_quotation', $data, function ($message) use ($email, $name) {
                $message->to($email, $name)->subject('Rhapsodie: Request Quotation Sent');
            });

            $provideremail     = $quotation->project->provider->email;
            $providername      = $quotation->project->provider->name;

            $providerdata  = [
                'quotation'              => $quotation,
                'email'                  => $request->email,
                'name'                   => $name,
                'content'                => $request->message,
                'phone'                  => $request->phone,
                'title'                  => 'New Request Quotation',
            ];
            \Mail::send('email.contact.request_quotation_provider', $providerdata, function ($message) use ($provideremail, $providername) {
                $message->to($provideremail, $providername)->subject('Rhapsodie: New Request Quotation');
            });

            return back()->with('success', 'Your Quotation has been sent! Thank You.');
        }
    }

    public function projectDetail($id)
    {
        $project                  = UserServiceProviderProject::with('images', 'videos')->find($id);
        $this->data['project']    = $project;
        return $this->renderView('frontend.pages.users.includes.ajax_project_detail');
    }
}
