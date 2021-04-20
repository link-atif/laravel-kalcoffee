<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\order_item_requested;
use Illuminate\Http\Request;
use Auth;
use Session;
use Image;
use App\Certificate;
use App\Variety;
use App\Process;
use App\Category;
use App\Product;
use App\CoffeeNote;
use App\Order;


class OrderItemRequestedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    
    {
        //dd($id);
       
        $data['page_title'] = "Invoice | Orders";
        $data['req'] = DB::table('orders')
        
        ->join('order_details','order_details.order_id','=','orders.id')

        ->join('order_item_requesteds','order_item_requesteds.order_id','=','orders.id')
        ->join('users','users.id','=','orders.user_id')
        ->select('orders.name','order_details.product_name','order_details.price','orders.user_id','order_details.bag_size','users.address_1','orders.country','orders.city','orders.grand_total','orders.id','order_item_requesteds.id as r_id','orders.updated_at','order_details.quantity','order_item_requesteds.sub_total','order_item_requesteds.remaining','order_item_requesteds.updated_at','order_item_requesteds.quantity as qu','order_item_requesteds.status','order_item_requesteds.id as r_id','orders.order_status')
        ->where('orders.id','=',$id)
        //->where('schedule_id',$id)

        ->orderBy('id', 'DESC')->paginate(4);
       //dd($data);
      //  $data['record']=DB::table('order_item_requesteds')
        return view('admin.view_invoice',$data);
        
    }  
     public function approved(Request $request,$r_id)
          
    {
        
        order_item_requested::where('id', $r_id)->update(array('status' => 'Approved'));
//dd($r_id);
        // $data['page_title'] = "Invoice | Orders";
        // $data['req'] = DB::table('orders')
        // ->join('order_details','order_details.order_id','=','orders.id')
        // ->join('order_item_requesteds','order_item_requesteds.order_id','=','orders.id')
        // ->join('users','users.id','=','orders.user_id')
        // ->select('orders.name','order_details.product_name','order_details.price','orders.user_id','order_details.bag_size','users.address_1','orders.country','orders.city','orders.grand_total','orders.id','order_item_requesteds.id as r_id','orders.updated_at','order_details.quantity','order_item_requesteds.sub_total','order_item_requesteds.remaining','order_item_requesteds.updated_at','order_item_requesteds.quantity as qu','order_item_requesteds.status','order_item_requesteds.id as r_id','orders.order_status')
        // ->where('orders.id','=',$id)
        // //->where('schedule_id',$id)

        // ->get();
       //dd($data);
      //  $data['record']=DB::table('order_item_requesteds')
         return redirect()->back();

        // return redirect('admin/view-schedules')->with('flash_message_success','Mail has been added successfully!');
        
    }


         public function uApproved(Request $request,$id)
          
    {
        
        Order::where('id', $id)->update(array('order_status' => 'Approved'));
//dd($r_id);
        // $data['page_title'] = "Invoice | Orders";
        // $data['req'] = DB::table('orders')
        // ->join('order_details','order_details.order_id','=','orders.id')
        // ->join('order_item_requesteds','order_item_requesteds.order_id','=','orders.id')
        // ->join('users','users.id','=','orders.user_id')
        // ->select('orders.name','order_details.product_name','order_details.price','orders.user_id','order_details.bag_size','users.address_1','orders.country','orders.city','orders.grand_total','orders.id','order_item_requesteds.id as r_id','orders.updated_at','order_details.quantity','order_item_requesteds.sub_total','order_item_requesteds.remaining','order_item_requesteds.updated_at','order_item_requesteds.quantity as qu','order_item_requesteds.status','order_item_requesteds.id as r_id','orders.order_status')
        // ->where('orders.id','=',$id)
        // //->where('schedule_id',$id)

        // ->get();
       //dd($data);
      //  $data['record']=DB::table('order_item_requesteds')
         return redirect()->back();

        // return redirect('admin/view-schedules')->with('flash_message_success','Mail has been added successfully!');
        
    }
    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function invoice()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request ,$product_id)
    {
        if($request->isMethod('post')){
            $data = request()->validate([
                'product_id' => 'required',
                'order_id' => 'required',
                'quantity' => 'required',
                'remaining' => 'required',                
                'sub_totall' => 'required',
            
            ]);

            $data = $request->all();
            $product = new order_item_requested;
            $product->product_id = $data['user_id'];
            $product->product_id = $data['product_id'];
            $product->order_id = $data['order_id'];
            $product->quantity = $data['quantity'];
            $product->remaining = $data['remaining'];
            $product->sub_total = $data['sub_total'];
            $product->save();
            dd($product);
            return redirect('home/view-details')->with('flash_message_success','Product has been added successfully!');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\order_item_requested  $order_item_requested
     * @return \Illuminate\Http\Response
     */
    public function show(order_item_requested $order_item_requested)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\order_item_requested  $order_item_requested
     * @return \Illuminate\Http\Response
     */
    public function edit(order_item_requested $order_item_requested)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\order_item_requested  $order_item_requested
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, order_item_requested $order_item_requested)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\order_item_requested  $order_item_requested
     * @return \Illuminate\Http\Response
     */
    public function destroy(order_item_requested $order_item_requested)
    {
        //
    }
}
