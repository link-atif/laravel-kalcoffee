<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Auth;
use Session;
use App\User;
use App\Product;
use App\Category;
use App\Courses;
use App\Media;
use App\Client;
use App\Contact;
use App\Solution;
use App\Page;
use App\Faq;
use App\Preference;
use App\Schedule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class HomeController extends Controller{
	public function index(){
        $data['products'] = Product::orderBy('id','DESC')->take(3)->get();
        $data['categories'] = Category::orderBy('id','DESC')->get();
        $data['courses'] = Courses::orderBy('id','DESC')->take(3)->get();
        $data['media'] = Media::orderBy('id','DESC')->take(4)->get();
        $data['clients'] = Client::orderBy('id','DESC')->take(5)->get();

        $data['products_status'] = Preference::where('name','products')->pluck('value')->first();
        $data['training_status'] = Preference::where('name','training')->pluck('value')->first();
        $data['media_status'] = Preference::where('name','media')->pluck('value')->first();
        $data['clients_status'] = Preference::where('name','clients')->pluck('value')->first();

        $data['aboutus_picture'] = Preference::where('name','aboutus_picture')->pluck('value')->first();
        $data['aboutus_title'] = Preference::where('name','aboutus_title')->pluck('value')->first();
        $data['aboutus_description1'] = Preference::where('name','aboutus_description1')->pluck('value')->first();
        $data['aboutus_description2'] = Preference::where('name','aboutus_description2')->pluck('value')->first();
        $data['aboutus_button_text'] = Preference::where('name','aboutus_button_text')->pluck('value')->first();

        $data['page_title'] = "Home | Kal-Coffee";
		$data['page'] = "home";
        return view('index', $data);
 	}

    public function contactus(){
     $data['page_title'] = "Contact Us | Kal-Coffee";
     $data['page'] = "contactus";
     return view('home/contact_us', $data);   
    }

    public function solutions(){
     $data['page_title'] = "Services & Solution | Kal-Coffee";
     $data['page'] = "solutions";
     return view('home.request_solution', $data);   
    }

    public function pages($slug){
        $data['page_data'] = Page::where('slug',$slug)->first();
        $data['page_title'] = $data['page_data']->title." | Kal-Coffee";
        return view('home/page', $data);   
    }

    public function about_us(){
        $data['page_data'] = Page::where('slug','about-kal-coffee')->first();
        $data['page_title'] = $data['page_data']->title." | Kal-Coffee";
        return view('home/page', $data);
    }

    public function contact_queries(Request $request){
        if($request->isMethod('post')){
            $data = request()->validate([
                'name' => 'required',
                'contact_name' => 'required',
                'email' => 'required',
                'contact' => 'required',
            ]);

            $data = $request->all();
            $contact = new Contact;
            $contact->full_name = $data['name'];
            $contact->email = $data['email'];
            $contact->contact_name = $data['contact_name'];
            $contact->contact = $data['contact'];
            $contact->subject = "Contact Us Form Data";
            $contact->message = (!empty($data['note'])) ? $data['note'] : "";
            $contact->entity_age = (!empty($data['entity_age'])) ? $data['entity_age'] : "";
            $contact->dealing_as = (!empty($data['dealing'])) ? $data['dealing'] : "";

            $contact->save();
            return redirect()->back()->with('flash_message_success','Contact Form Submit successfully!');
        }
    }

    public function request_solution(Request $request){
        if($request->isMethod('post')){
            $data = request()->validate([
                'entity_name' => 'required',
                'contact_name' => 'required'
            ]);

            $data = $request->all();
            $contact = new Solution;
            $contact->entity_name = $data['entity_name'];
            $contact->contact_name = $data['contact_name'];
            $contact->requirement = $data['requirement'];            
            $contact->notes = (!empty($data['notes'])) ? $data['notes'] : "";
            $contact->entity_age = (!empty($data['entity_age'])) ? $data['entity_age'] : "";
            $contact->dealing_as = (!empty($data['dealing_as'])) ? $data['dealing_as'] : "";

            $contact->save();
            return redirect()->back()->with('flash_message_success','Your Request has been Submitted successfully!');
        }
    }

 	public function add_to_cart(Request $request, $id = null){
 		if($request->isMethod('post')){
            $data = request()->validate([
                'product_id' => 'required',
                'product_code' => 'required',
                'product_name' => 'required',
                'price' => 'required',
            	'quantity' => 'required|min:1'
            ]);

            $data = $request->all();
            $session_id = Session::get('session_id');
            if(empty($session_id)){
            	$session_id = Str::random(40);
            	Session::put('session_id',$session_id);
            }
            $countItems = DB::table('cart')->where(['product_id' => $data['product_id'], 'session_id' => $session_id])->count();
            
            if($countItems > 0 ){
            	$p_id = $data['product_id'];
            	$q  = $data['quantity'];
            	$data['cartData'] = DB::table('cart')->where(['product_id' => $p_id, 'session_id' => $session_id])->increment('quantity',$q);
            }else{
            	$newArray = array(
	                'product_id' => $data['product_id'],
	                'product_name' => $data['product_name'],
	                'product_code' => $data['product_code'],
	                'user_email' => (!empty($data['user_email'])) ? $data['user_email'] : "",
	                'session_id' => $session_id,
	                'price' => $data['price'],
	                'quantity' => $data['quantity']
            	);
           		DB::table('cart')->insert($newArray);
            }
        }

        $data['product'] = Product::where('id',$id)->firstorfail();
		$data['categories'] = Category::orderBy('id','DESC')->get();
		$data['page_title'] = "Product Details";
		return view('home.product_details', $data);
 	}

    public function faqs(){
        $data['page_title'] = "Kal-Coffee | FAQS";
        $data['faqs'] = Faq::get();
        return view('home/faqs', $data);   
    }
}
