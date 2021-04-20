<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Preference;
use App\Slider;
use App\Page;

class PartialsController extends Controller
{
    public function navbar(View $view)
    {
        $data['logo'] = Preference::where('name','logo')->pluck('value')->first();
        $data['slider'] = Slider:: orderBy('id','DESC')->take(5)->get();

        $data['header'] = Preference::where('name','header')->pluck('value')->first();
        $data['video_link'] = Preference::where('name','video_link')->pluck('value')->first();
        $data['plantool_popup_text'] = Preference::where('name','plantool_popup_text')->pluck('value')->first();

    	$view->with($data);
	}
	
	public function footer(View $view )
    {
        $data['toll_free'] = Preference::where('name','telephone')->pluck('value')->first();
        $data['email'] = Preference::where('name','email')->pluck('value')->first();
        $data['facebook'] = Preference::where('name','facebook_link')->pluck('value')->first();
        $data['twitter'] = Preference::where('name','twitter_link')->pluck('value')->first();
        $data['linkedin'] = Preference::where('name','linkedin_link')->pluck('value')->first();
        $data['google'] = Preference::where('name','google_plus_link')->pluck('value')->first();
        $data['open'] = Preference::where('name','opening_time')->pluck('value')->first();

		$data['copyright'] = Preference::where('name','footer_copyright')->pluck('value')->first();
        $data['quickLinks']  = Page:: orderBy('sort_order','ASC')->where('type','quick_links')->get();
        $data['coffee']  = Page:: orderBy('sort_order','ASC')->where('type','coffee')->get();
        $data['company']  = Page:: orderBy('sort_order','ASC')->where('type','company')->get();
    	$view->with($data);
    }

    public function header(View $view)
    {
        $data['logo'] = Preference::where('name','logo')->pluck('value')->first();
        $data['header'] = Preference::where('name','header')->pluck('value')->first();
        $data['video_link'] = Preference::where('name','video_link')->pluck('value')->first();
        $data['plantool_popup_text'] = Preference::where('name','plantool_popup_text')->pluck('value')->first();
        $view->with($data);
    }
}