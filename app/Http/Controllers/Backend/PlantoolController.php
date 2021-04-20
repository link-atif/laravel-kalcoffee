<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Plan;
use App\Category;
use App\Product;
use App\Order;
use App\order_item_requested;
class PlantoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['plans'] = Plan::paginate(10); 
        $data['page_title'] = "Plans";
        return view('admin.view_plans',$data);
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function requested()
    {
        


        //$data['req'] = order_item_requested::paginate(10); 
        $data['page_title'] = "Requested | Orders";
        $data['req'] = DB::table('orders')
        ->join('order_details','order_details.order_id','=','orders.id')
        ->join('order_item_requesteds','order_item_requesteds.order_id','=','orders.id')
        ->join('users','users.id','=','orders.user_id')
        ->select('orders.name','orders.id','order_details.product_name','order_item_requesteds.quantity','order_item_requesteds.remaining','order_item_requesteds.sub_total','orders.user_id','order_item_requesteds.id as r_id')
        //->where('schedule_id',$id)

        ->orderBy('id', 'DESC')->paginate(10);
        //dd($data);
        return view('admin.requested_orders',$data);
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function back()
    {
        


        //$data['req'] = order_item_requested::paginate(10); 
        $data['page_title'] = "Requested | Orders";
        $data['req'] = DB::table('orders')
        ->join('order_details','order_details.order_id','=','orders.id')
        ->join('order_item_requesteds','order_item_requesteds.order_id','=','orders.id')
        ->join('users','users.id','=','orders.user_id')
        ->select('orders.name','order_details.product_name','order_item_requesteds.quantity','order_item_requesteds.id as r_id','order_item_requesteds.remaining','order_item_requesteds.sub_total','orders.user_id','orders.id')
        //->where('schedule_id',$id)
        ->orderBy('id', 'DESC')->paginate(10);
       // dd($data);
        return view('admin.requested_orders',$data);
        
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyr($r_id)
    {
        order_item_requested::where(['id'=>$r_id])->delete();
        return redirect()->back()->with('flash_message_success','Plan deleted Successfully!');
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['categories'] = Category::where(['parent_id'=>0])->get();
        $data['products'] = Product::get();
        $data['page_title'] = "Add Plans";
        return view('admin.add_plans',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->isMethod('post')){
            $data = request()->validate([
                'category_id' => 'required',
                'type' =>'required',
                'recommendation' => 'required'
            ]);

            $data = $request->all();
            $product = new Plan;
            $product->category_id = $data['category_id'];
            $product->type = $data['type'];
            $product->notes = implode(',', $data['notes']);
            $product->recommendation = $data['recommendation'];

            $product->save();
            return redirect('admin/plans')->with('flash_message_success','Plan has been created successfully!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['plans'] = Plan::where(['id' => $id])->first();
        $data['categories'] = Category::where(['parent_id'=>0])->get();
        $data['products'] = Product::get();
        $data['page_title'] = "Edit Plan";
        return view('admin.edit_plans',$data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

           $data = request()->validate([
                'category_id' => 'required',
                'type' =>'required',
                'recommendation' => 'required'
            ]);
           $data = $request->all();
            $newArray = array(
                'category_id' => $data['category_id'],
                'type' => $data['type'],
                'notes' => implode(',', $data['notes']),
                'recommendation' => $data['recommendation']
            );


            Plan::where(['id'=>$id])->update($newArray);            
            return redirect('admin/plans')->with('flash_message_success','Plan has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        plan::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success','Plan deleted Successfully!');
    }

    public function loadProducts(Request $request){
        $products =  Product::where(['category_id'=> $request->id])->get();
        return \Response::json($products);
    }
}
