<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Coupon;
use App\Cart;
use App\Order;
use App\Card;
use App\OrderDetail;
use App\Product;
use Auth;
use App\Preference;
use Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller{
	
	public function index(){
        if(\Auth::id() && \Auth::user()->type=="trainee"){
            return redirect(route('products'))->with('flash_message_error','To buy coffee Please switch your account to business!');
        }
		$session_id = Session::get('session_id');
        $data['page_title'] = "Cart";
		$data['cartData'] = Cart::where(['session_id' => $session_id, 'type' => 'coffee'])->get();
        $data['v_tax'] = Preference::where('name','vat')->pluck('value')->first();
        /*if(count($data['cartData']) > 0){
            $data['total']  = Cart::where(['session_id' => $session_id])->sum('price');
            $data['vat'] = 5/100*$data['total'];
            $data['grand_total'] = $data['vat'] + $data['total'];
        }*/
	return view('home.cart',$data);	
	}

    public function add_to_cart(Request $request, $id = null){
        if($request->isMethod('post')){
            if(\Auth::id() && \Auth::user()->type=="trainee"){
                return redirect(route('product.details',$request->product_id))->with('flash_message_error','To buy coffee Please switch your account to business!');
            }
            $data = request()->validate([
                'product_id' => 'required',
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
            $countItems = Cart::where('product_id', $data['product_id'])->where('order_type', $data['type'])->where('session_id', $session_id)->count();
            if($countItems > 0){
                //$p_id = $data['product_id'];
                //$q  = $data['quantity'];
                //$data['cartData'] = Cart::where('product_id', $p_id)->where('session_id',$session_id)->increment('quantity',$q);
                return redirect(route('product.details',$data['product_id']))->with('flash_message_success',$data['product_name'].' is already in cart!');
            }else{
                $newArray = array(
                    'product_id' => $data['product_id'],
                    'product_name' => $data['product_name'],
                    'product_code' => (!empty($data['product_code'])) ? $data['product_code'] : "",
                    'user_email' => (!empty($data['user_email'])) ? $data['user_email'] : "",
                    'image' => (!empty($data['image'])) ? $data['image'] : "",
                    'session_id' => $session_id,
                    'price' => $data['price'],
                    'quantity' => $data['quantity'],
                    'bag_size' => $data['bag_size'],
                    'type' => "coffee",
                    'order_type' => $data['type'],
                );
                if($data['type'] == "sample"){
                    $newArray['price'] = 0;
                    $newArray['bag_size'] = 0;
                    $newArray['quantity'] = 1;
                }          

                Cart::create($newArray);
                return redirect(route('product.details',$data['product_id']))->with('flash_message_success',$data['product_name'].' added to cart successfully!');
            }
        }
    }

	public function delete_item($id = null){
		$data['cartData'] = Cart::where(['id' => $id])->delete();
		return redirect(route('cart.details'))->with('flash_message_success','Product deleted Successfully!');
	}

	public function update_quantity(Request $request){
		$data['cartData'] = Cart::where(['id' => $request->cart_id])->update(['quantity' => $request->quantity]);
		return redirect()->back()->with('flash_message_success','Quantity Updated Successfully!');
	}
 	

    public function payment(Request $request){
        $data['page_title'] = "Paymment | Kal-Coffee";
        $data['page'] = "payment";
        $data['type'] = "business";
        $data['bank_name'] = Preference::where('name','bank_name')->pluck('value')->first();
        $data['iban'] = Preference::where('name','iban')->pluck('value')->first();
        $data['amount'] = 0;
        if($request->isMethod('post')){
            $formData = $request->all();        
            $session_id = Session::get('session_id');
            $data['discount_code'] = $formData['discount_code'];
            $data['grand_total'] = $formData['grand_total'];
            if($formData['discount_code'] !=""){
                $coupon = Coupon::where(['code' => $formData['discount_code'], 'status' => '1'])->where('expiry_date', '>=' , Carbon::today()->toDateString())->first();
                if(!empty($coupon)){
                    if($coupon->type == 'amount'){
                        $data['amount'] = $coupon->value;
                        $data['grand_total'] = $formData['grand_total'] - $coupon->value;
                    }
                    if($coupon->type == 'percentage'){
                        $data['amount'] = $coupon->value/100*$formData['grand_total'];
                        $data['grand_total'] = $formData['grand_total'] - $data['amount'];
                    }

                }
            }
            Session::put('total',$formData['sub_total']);
            Session::put('vat',$formData['vat']);
            Session::put('grand_total',$data['grand_total']);
            Session::put('amount',$data['amount']);
            Session::put('discount_code', $formData['discount_code']);
        }       
        //$userDetails = Auth::user();
        return view('home/training_payment', $data);
    }
    
    public function checkout(Request $request){
        if($request->isMethod('post')){
            if($request->payment_method == 'pay'){
                $data = request()->validate([
                    'name_on_card' => 'required',
                    'card_number' => 'required',
                    'cvv' => 'required|min:3|max:5',
                    'expiration' => 'required'
                ]);
            }
            
            $data = $request->all();
            $session_id = Session::get('session_id');
            $userDetails = Auth::user();
            
            $order = new Order;
            $order->user_id = $userDetails->id;
            $order->user_email = $userDetails->email;
            $order->name = $userDetails->name;
            $order->city = $userDetails->city ? $userDetails->city : "";
            $order->country = $userDetails->country ? $userDetails->country : "";
            $order->address = $userDetails->address_1 ? $userDetails->address_1 : "";
            $order->mobile = $userDetails->phone_number ? $userDetails->phone_number : "";
            $order->shipping_charges = 0;
            $order->payment_method = $data['payment_method'];
            $order->order_status = "pending";
            $order->grand_total = $data['grand_total'];
            $order->type = $data['type'];
            $order->coupon_code = $data['discount_code'];
            $order->coupon_amount = $data['discount_amount'];
            $order->vat = $data['vat'];
            $order->save();
            
             
            $orderId = DB::getPdo()->lastInsertId();

            if($data['payment_method'] == 'pay'){
                $card = new Card;
                $card->user_id = $userDetails->id;
                $card->order_id = $orderId;
                $card->name_on_card = $data['name_on_card'];
                $card->cvv = $data['cvv'];
                $card->expiration = $data['expiration'];
                $card->card_number = $data['card_number'];
                $card->save();
            }

            $cartData = DB::table('cart')->where(['session_id' => $session_id, 'type' => 'coffee'])->get();
            $grand_total = 0;
            foreach ($cartData as $key => $c) {
                $cartPro = new OrderDetail; 
                $cartPro->order_id = $orderId;
                $cartPro->user_id = $userDetails->id;
                $cartPro->product_id = $c->product_id;
                $cartPro->product_name = $c->product_name;
                $cartPro->product_code = "";
                $cartPro->quantity = $c->quantity;
                $cartPro->price = $c->price;
                $cartPro->bag_size = $c->bag_size;
                $cartPro->save();
                Cart::where(['session_id' => $session_id])->delete();
                $this->destroySessions();
            }

            //pdf and send mail
            $data['invoice_number'] = $orderId;
            
            $data['sub_total'] = Session::get('total');
            $data['tax'] = Session::get('vat');
            $data['grand_total'] = Session::get('grand_total');
            $data['discount_amount'] = Session::get('amount');
            $data['discount_code'] = Session::get('discount_code');
            $data['v_tax'] = Preference::where('name','vat')->pluck('value')->first();
            $data['cartData'] = $cartData;

            $data["email"]= \Auth::user()->email;
            $data["client_name"]= \Auth::user()->name;
            $data["address"]= \Auth::user()->address_1;
            $data['date'] = Carbon::parse(today()->toDateString())->format('m/d/Y');
            $data["subject"]= "Order Invoice";
            //$message_body = "Your Order is Placed Successfully. Please find your order invoice below.";

           // $pdf = PDF::loadView('home.invoice', $data);
            //$path = storage_path('app/public/frontend/')."invoice.pdf";
            //$pdf->save($path);

            // Mail::send('home.mail_message', $data, function($message)use($data,$pdf) {
            //     $message->to($data["email"], $data["client_name"])
            //     ->subject($data["subject"])
            //     ->attachData($pdf->output(), "invoice.pdf");
            // });

            ////
            Cart::where(['session_id' => $session_id])->delete();
            $this->destroySessions();

            $data['bank_name'] = Preference::where('name','bank_name')->pluck('value')->first();
            $data['iban'] = Preference::where('name','iban')->pluck('value')->first();
            
            $data['page_title'] = "Thankyou | Kal-Coffee";
            $data['page'] = 'thankyou';
            return view('home/thankyou', $data);
        }
        return redirect('/');       
    }

    ////////////////////Done by G.Ali/////////////////////
    public function checkoutSaler(Request $request){  
        if(\Auth::id() && \Auth::user()->isWholeSale=="Yes")
        {
        $data = $request->all();
        $session_id = Session::get('session_id');
        $userDetails = Auth::user();       
        $order = new Order;
        $order->user_id = $userDetails->id;
        $order->user_email = $userDetails->email;
        $order->name = $userDetails->name;
        $order->city = $userDetails->city ? $userDetails->city : "";
        $order->country = $userDetails->country ? $userDetails->country : "";
        $order->address = $userDetails->address_1 ? $userDetails->address_1 : "";
        $order->mobile = $userDetails->phone_number ? $userDetails->phone_number : "";
        $order->shipping_charges = 0;      
        $order->order_status = "pending";      
        $order->save();


        $orderId = DB::getPdo()->lastInsertId();

        // if($data['payment_method'] == 'pay'){
        //     $card = new Card;
        //     $card->user_id = $userDetails->id;
        //     $card->order_id = $orderId;
        //     $card->name_on_card = $data['name_on_card'];
        //     $card->cvv = $data['cvv'];
        //     $card->expiration = $data['expiration'];
        //     $card->card_number = $data['card_number'];
        //     $card->save();
        // }

        $cartData = DB::table('cart')->where(['session_id' => $session_id, 'type' => 'coffee'])->get();
        $grand_total = 0;
        foreach ($cartData as $key => $c) {
            $cartPro = new OrderDetail; 
            $cartPro->order_id = $orderId;
            $cartPro->user_id = $userDetails->id;
            $cartPro->product_id = $c->product_id;
            $cartPro->product_name = $c->product_name;
            $cartPro->product_code = "";
            $cartPro->quantity = $c->quantity;
            $cartPro->price = $c->price;
            $cartPro->bag_size = $c->bag_size;
            $cartPro->save();
         }
        Cart::where(['session_id' => $session_id])->delete();
        $this->destroySessions();
         $data['page_title'] = "Thankyou | Kal-Coffee";
        $data['page'] = 'thankyou';
        return view('home/thankyou', $data);
        }      
        return redirect('/');   
    }

        public function bulkCart(Request $request){
        if($request->isMethod('post')){
            $ids = json_decode($request['ids']);
            $session_id = Session::get('session_id');
            if(empty($session_id)){
                $session_id = Str::random(40);
                Session::put('session_id',$session_id);
            }
            foreach($ids as $id){
                $product_detail = Product::where('id',$id)->first();
                $countItems = Cart::where('product_id', $product_detail->id)->where('session_id', $session_id)->count();

                if($countItems > 0 ){
                    $q  = 1;
                    $data['cartData'] = Cart::where('product_id', $product_detail->id)->where('session_id',$session_id)->increment('quantity',$q);
                }else{
                    $newArray = array(
                        'product_id' => $product_detail->id,
                        'product_name' => $product_detail->product_name,
                        'product_code' => $product_detail->product_code,
                        'user_email' => "",
                        'image' => $product_detail->image,
                        'session_id' => $session_id,
                        'price' => $product_detail->price,
                        'quantity' => 1,
                        'bag_size' => $product_detail->bag_size,
                        'type' => "coffee",
                        'order_type' => 'full'
                    ); 
                    Cart::create($newArray);
                }
            }
            return redirect(route('cart.details'));
        }
    }

    public function destroySessions(){
        Session::forget('session_id');
        Session::forget('total');
        Session::forget('vat');
        Session::forget('amount');
        Session::forget('discount_code');
        Session::forget('grand_total');
    }
}