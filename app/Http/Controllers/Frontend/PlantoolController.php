<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CoffeeNote;
use App\Category;
use App\Product;
use App\Coupon;
use App\Plan;
use Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PlantoolController extends Controller
{
    public function index(){
    	$data['page_title'] = "Kal-Coffee | Plan Tools";
    	$data['page'] = "plantool";
        $data['categories'] = Category::where(['parent_id'=>0])->get();
        $data['espresso_notes'] = CoffeeNote::where(['type'=> 'Espresso'])->get();
        $data['filtered_notes'] = CoffeeNote::where(['type' => 'Filtered Coffee'])->get();
    	return view('home.plan_tool',$data);
    }

    public function planToolsNewCafe(){
    	$data['page_title'] = "Kal-Coffee | Plan Tools (New Cafe)";
    	$data['page'] = "plantool";
        $data['categories'] = Category::where(['parent_id'=>0])->get();
        $data['espresso_notes'] = CoffeeNote::where(['type'=> 'Espresso'])->get();
        $data['filtered_notes'] = CoffeeNote::where(['type' => 'Filtered Coffee'])->get();
        return view('home.plan_tool_new',$data);
    }

    public function planToolsRequest(Request $request){
    	$data['page_title'] = "Kal-Coffee | Plan Tools Request";
    	$data['page'] = "plantool";
        if($request->isMethod('post')){
            $data = request()->validate([
                'entity_name' => 'required',
                'contact_name' => 'required'
            ]);

            $data = $request->all();
            $contact = new Plan;
            $contact->entity_name = $data['entity_name'];
            $contact->contact_name = $data['contact_name'];
            $contact->requirement = $data['requirement'];            
            $contact->notes = (!empty($data['notes'])) ? $data['notes'] : "";
            $contact->entity_age = (!empty($data['entity_age'])) ? $data['entity_age'] : "";
            $contact->dealing_as = (!empty($data['dealing_as'])) ? $data['dealing_as'] : "";

            $contact->save();
            return redirect()->back()->with('flash_message_success','Your Request has been Submitted successfully!');
        }

    	return view('home.planToolsRequestForm',$data);	
    }

    public function planSolution(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $espresso_notes = implode(',', $data['espresso_notes']);
            $filtered_notes = implode(',', $data['filtered_notes']);
            
            $data['plantool_type'] = ($data['type'] == "new") ? "New Cafe" : "";            
            $data['espresso_products']  = Product::where('espresso_notes',$espresso_notes)->get();
            $data['filtered_products']  = Product::where('filtered_notes',$filtered_notes)->get();
            $data['code'] = "";
            if($data['espresso_products']->count() > 0 || $data['filtered_products']->count() > 0){
                $coupons = new Coupon;
                $coupons->code = Str::random(7);
                $coupons->type = 'percentage';
                $coupons->value = 5;
                $coupons->status = '1';
                $coupons->expiry_date = Carbon::today()->addDays(7)->toDateString();           
                $coupons->save();       
                
                $data['code'] = $coupons->code;
                $data['value'] = 5;
                $data['expiry_date'] = Carbon::today()->addDays(7)->toDateString();
            }
        }
        
        $data['page_title'] = "Kal-Coffee | Plan Tools Solutions";
        $data['page'] = "plantool";

        return view('home.plan_tool_suggestions', $data);
    }
}
