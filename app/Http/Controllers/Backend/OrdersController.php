<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Session;
use Image;
use App\certificate;
use App\Variety;
use App\Process;
use App\Category;
use App\Product;
use App\Order;
use App\OrderDetail;

class OrdersController extends Controller
{
   public function viewOrders(){
        $data['orders'] = Order::where('type','coffee')->orderBy('id', 'DESC')->paginate(4);
        $data['order'] = Order::where('type','business')->orderBy('id', 'DESC')->paginate(4);
       //dd($data);
        $data['page_title'] = "Orders | kal-Coffee";
        return view('admin.view_orders',$data);
    }

    public function viewEnrollments(){
        $data['orders'] = Order::where('type','training')->orderBy('id', 'DESC')->paginate(4);
       //dd($data);
        $data['page_title'] = "Trainings | kal-Coffee";
        return view('admin.view_orders',$data);
    }

    public function viewDetails($id = null){
    	$data['details'] = Order::where('id',$id)->first();

        $data['page_title'] = "Details | kal-Coffee";
        $data['page_heading'] = "Order Details";
        //dd('$data');
        return view('admin.view_order_detail',$data);	
    }

    public function updateOrderStatus(Request $request){
     
        $newArray = array(
            'order_status' => $request->status
        );
        Order::where(['id'=>$request->order_id])->update($newArray);
        return redirect()->back()->with('flash_message_success','Status updated Successfully!');
    }

    public function updateOrder(Request $request){
       //dd($request);
        
        $totall = $request->fee;
        //dd($totall);
        $id = $request->order_id;
        
      
        Order::where('id', $id)->update(array('payment_method' => 'pay','order_status' => 'approved','grand_total' => $totall));

        return redirect()->back()->with('flash_message_success','Status updated Successfully!');
    }
}
