<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Coupon;
use Auth;
use Session;
use Image;

class CouponsController extends Controller{
    public function addCoupons(Request $request){
    	if($request->isMethod('post')){
            $data = request()->validate([
                'code' => 'required',
                'value' => 'required',
                'expiry_date' => 'required'
            ]);

    		$data = $request->all();
    		$coupons = new Coupon;
    		$coupons->code = $data['code'];
    		$coupons->type = $data['type'];
    		$coupons->value = $data['value'];
    		$coupons->status = $data['status'];
            $coupons->expiry_date = $data['expiry_date'];    		
    		$coupons->save();

            return redirect('admin/view-coupons')->with('flash_message_success','Coupon has been added successfully!');
    	}
    	$page_title = "Add Coupon";
    	return view('admin.add_coupon')->with(compact('page_title'));
    }

    public function viewCoupons(){
        $coupons = DB::table('coupons')->paginate(10);
        $page_title = "Coupons";
        return view('admin.view_coupons')->with(compact('coupons','page_title'));
    }

    public function editCoupons(Request $request, $id = null){
        if($request->isMethod('post')){
            $data = request()->validate([
                'code' => 'required',
                'value' => 'required',
                'expiry_date' => 'required'
            ]);

            $data = $request->all();
            $newArray = array(
                'code' => $data['code'],
                'type' => $data['type'],
                'value' => $data['value'],
                'status' => $data['status'],
                'expiry_date' => $data['expiry_date']
            );

            Coupon::where(['id'=>$id])->update($newArray);
            return redirect('/admin/view-coupons')->with('flash_message_success','Coupons details updated Successfully!');
        }

        $page_title = "Edit Coupon";
        $couponsDetails = Coupon::where(['id'=>$id])->first();        
        return view('admin.edit_coupons')->with(compact('couponsDetails','page_title'));
    }

    public function deleteCoupons(Request $request, $id = null){
        if(!empty($id)){
            Coupon::where(['id'=>$id])->delete();
            return redirect()->back()->with('flash_message_success','Coupon deleted Successfully!');
        }
    }
}
