<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

use App\order_item_requested;
use App\Order;
use App\OrderDetail;
use Auth;



class OrderItemRequestedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
    public function index()
    {
        //
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

    /////////////// This function for Requested items storing\\\\\\\\\\\\\\\\\

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request )
    {
       // $a= Auth::user()->id;
       // dd($a);
        if($request){
            $data = request()->validate([
                'product_id' => 'required',
                'order_id' => 'required',
                'quantity' => 'required|integer|min:0',
                'remaining' => 'required|integer|min:0',                
                'sub_total' => 'required',

     
            ]);

            $data = $request->all();
            $item = new order_item_requested;
            $item->user_id = $data['user_id'];
            $item->product_id = $data['product_id'];
            $item->order_id = $data['order_id'];
            $item->quantity = $data['quantity'];
            $item->remaining = $data['remaining'];
            $item->sub_total = $data['sub_total'];
            $item->save();
            //dd($item);
        
        //     $data = DB::table('order_details')
        //     //->join('order_details','order_details.order_id','=','orders.id')
        //     //->join('order_details','order_details.order_id','=','order_details.id')
        //     ->join('order_item_requesteds','order_item_requesteds.user_id','=','order_details.user_id')
        //     ->join('users','users.id','=','order_details.user_id')
        //     ->select('order_item_requesteds.remaining','order_details.user_id','order_details.product_name','order_details.product_code','order_details.quantity')
           
        //   //dd($mail);
        //     ->where('order_details.user_id', Auth::user()->id)
        //     //->where('order_item_requesteds.remaining','>',0)
        //     ->get();
        //     //->get();
        //     //dd($mail);
        //     //$items=order_item_requested::where('user_id', Auth::user()->id)->get();
        //     // DB::table('order_details')->where('order_id', $request->input('order_id'))->decrement('quantity', $request->input('quantity'));
        //     //dd($items);
        //     //OrderDetail::find($items->user_id)->decrement('quantity',$items->quantity);
        //     //dd($item);
        //         // $data['page_title'] = "Details | Kal-Coffee";
        //         // $data['page'] = "view_details";
        //         // $data['user'] = Auth::user();
        //         // $data['orders'] = order_item_requested::where('user_id', Auth::user()->id)->where('quantity','>',0)->get();
        //         dd($data);
        //         return view('home.view_details', $data);
    
        // }
       // dd("nothing data");

        //$data['page_title'] = "Dashboard | Kal-Coffee";
        //$data['page'] = "dashboard";
        //$data['user'] = Auth::user();
        //$data['orders'] = OrderDetail::where('user_id', Auth::user()->id)->where('order_id',$id)->get();
        
        //dd($data);
        return redirect()->back()->with('flash_message_success','Order Requested Successfully!');
        //return view('home.dashboard', $data);
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
