<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Courses;
use App\Coupon;
use App\Level;
use App\Schedule;
use App\Cart;
use App\Order;
use App\Card;
use App\OrderDetail;
use Auth;
use Session;
use App\Preference;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\Mail;

class TrainingController extends Controller
{
    public function index(){
        $data['page_title'] = "Training | Kal-Coffee";
		$data['page'] = "training";		
        return view('home/training', $data);
 	}

 	    public function attendies(){
 	    	
 	        $data['page_title'] = "Course | Kal-Coffee";
 			$data['page'] = "Course Details";
            // $od = OrderDetail::pluck('schedule_id');
            //$data['detail'] = Schedule::paginate(10); 
             //dd($od);
    //         $i =1;
    //         foreach ($od as   $key => $o ) {
    //           //dd($o);	
    //         	$data['co'][$i] = DB::table('order_details')
				// ->join('courses','courses.id','=','order_details.course_id')
				// ->join('users','users.id','=','order_details.user_id')
    //             ->select('order_details.user_id','courses.*','order_details.schedule_id')
				// ->where('order_details.schedule_id',$o)
				// ->get()
				// ->count('order_details.order_id');
				//  $i++;
    //         }
            //dd($data);
            $data['course'] = Courses::paginate(5);
            //dd($data);
 	        return view('admin/attendence', $data);
 	 	} 	   


        public function attendiesDetails(Schedule $mail,$id){
  

      $schedule=Schedule::find($id);

      $data['mail'] = DB::table('orders')
      ->join('order_details','order_details.order_id','=','orders.id')
      ->select('orders.*','order_details.schedule_id as a_id','orders.grand_total','order_details.user_id','order_details.schedule_date')
      ->where('order_details.schedule_id',$id)
      ->paginate(5);
      $a_id=OrderDetail::where('schedule_id',$id)->pluck('course_id')->first();
      //dd( $a_id);
      $data['page_title'] = "Attendies Details | Kal-Coffee";
       $data['course_name'] =  courses::where('id', $a_id)->pluck('name')->first();
      return view('admin/view_attendies',$data);
    }

    public function searchAttendies(Request $request){

          $id = $request->a_id;
         
          //$schedule=Schedule::find($id);
         $name =$request->name ? $request->name : "";
         
         $data['mail'] = DB::table('orders')
      ->join('order_details','order_details.order_id','=','orders.id')
      ->select('orders.*','order_details.schedule_id as a_id','orders.grand_total','order_details.user_id','order_details.schedule_date')
      ->where('order_details.schedule_id',$id)
      ->where('orders.name','like',$name)
      ->orWhere('orders.user_email','like',$name)
      ->paginate(10);

          $a_id=OrderDetail::where('schedule_id',$id)->pluck('course_id')->first();
          //dd( $a_id);
          $data['page_title'] = "Attendies Details | Kal-Coffee";
           $data['course_name'] =  courses::where('id', $a_id)->pluck('name')->first();
          return view('admin/view_attendies',$data);
        }



 // $request->validate([
 //            'query'=>'required',
 //           ]);
 //           $query =$request->input('query');
 //           $product = Product::where ( 'name', 'LIKE', '%' . $query . '%' )->orWhere ( 'price', 'LIKE', '%' . $query . '%' )->paginate(4);




        public function attendiesDetail(Schedule $mail,$id){


      $schedule=courses::find($id);

      $data['mail'] = DB::table('orders')
      ->join('order_details','order_details.order_id','=','orders.id')
      ->select('orders.*','order_details.schedule_id as a_id' ,'order_details.course_id','order_details.schedule_date' )
      ->where('order_details.course_id',$id)
      ->paginate(5);
      $data['page_title'] = "Course | Details";
      $data['course_name'] =  courses::where('id',$id)->pluck('name')->first();

      return view('admin/view_attendies', $data);
    }

 	



 	public function calendar_data(){
 		$result = Courses::all();		
		$training = array();
		$i = 0;
		foreach($result as $r => $value){
			$levels = Level::where('course_id',$value->id)->get();
			foreach($levels as $key => $val){
				$start_date =  Schedule::where('course_id',$value->id)->where('level_id', $val->id)->where('schedule_date', '>=', Carbon::today()->toDateString())->orderBy('schedule_date', 'ASC')->pluck('schedule_date')->first();
				$end_date =  Schedule::where('course_id',$value->id)->where('level_id',$val->id)->orderBy('schedule_date', 'DESC')->pluck('schedule_date')->first();
				if($end_date >= Carbon::today()->toDateString()){
					$training[$i]['title'] = $value->name." - ".$val->name;
					$training[$i]['start'] = $start_date;
					$training[$i]['end'] = $end_date;
					$training[$i]['url'] = url('training_details/'.$value->id.'/'.$val->id); 
					$i++;
				}

			}
		}

		return \Response::json($training);
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

 	public function training_details($id = null, $level_id = null){
 		$data['page_title'] = "Training Details | Kal-Coffee";
		$data['page'] = "training";
		$data['level_id'] =  ($level_id!=null) ? $level_id : $id;
		$data['course'] = Courses::where('id',$id)->first();
		
		if($level_id !=null)
			$data['level_details'] = Level::where('id',$level_id)->first();
 			
 		if($level_id == null)
 			$data['level_details'] = Level::where('course_id',$id)->first();	
    	   
 		$data['schedule'] = Schedule::where('course_id',$id)->first();
 		return view('home/training_details', $data);
 	}

 	public function training_cart($id = null){
 		$data['page_title'] = "Training Cart | Kal-Coffee";
		$data['page'] = "training";
		$session_id = Session::get('session_id');
		if(\Auth::id() && \Auth::user()->type=="business"){
            return redirect(route('training'))->with('flash_message_error','For training enrollment please switch your account to Trainee!');
        }
		if($id !=null){
			$data['schedule'] = Schedule::where('id',$id)->first();
	 		$data['course'] = Courses::where('id',$data['schedule']->course_id)->first();
	 		
	 		$data['level'] = Level::where('id',$data['schedule']->level_id)->first();
	        if(empty($session_id)){
	        	$session_id = Str::random(40);
	        	Session::put('session_id',$session_id);
	        }
	        $countItems = DB::table('cart')->where(['schedule_id' => $data['schedule']->id, 'session_id' => $session_id])->count();

	        if($countItems < 1){
	        	$newArray = array(
	        		'product_id' => $data['schedule']->id,
	        		'product_name' => $data['course']->name,
	        		'product_code' => "",
	                'schedule_id' => $data['schedule']->id,
	                'level_id' => $data['level']->id,
	                'course_id' => $data['course']->id,
	                'user_email' => (!empty($data['user_email'])) ? $data['user_email'] : "",
	                'session_id' => $session_id,
	                'price' => $data['level']->price,
	                'quantity' => 1,
	                'level_name' => $data['level']->name,
	                'schedule_date' => $data['schedule']->schedule_date,
	                'image' => $data['course']->image,
	                'type' => 'training'
	        	);
	       		Cart::create($newArray);
	        }
	        $data['cartData'] = DB::table('cart')->where(['session_id' => $session_id, 'type' => 'training'])->get();
	        $data['total']  = DB::table('cart')->where(['session_id' => $session_id, 'type' => 'training'])->sum('price');
	        $data['vat'] = 5/100*$data['total'];
	        $data['grand_total'] = $data['vat'] + $data['total'];
 		}else{
 			if(!empty($session_id)){ 			
	 			$count = Cart::where(['session_id' => $session_id])->count();
	 			if($count > 0){
		 			$data['cartData'] = DB::table('cart')->where(['session_id' => $session_id, 'type' => 'training'])->get();
			        $data['total']  = DB::table('cart')->where(['session_id' => $session_id, 'type' => 'training'])->sum('price');
			        $data['vat'] = 5/100*$data['total'];
			        $data['grand_total'] = $data['vat'] + $data['total'];
	 			}else{
	 				$data['cartData'] = array();
	 			}
 			}else{
 				$data['cartData'] = array();
 			}
 		}
 		//dd($data);
 		return view('home/training_cart', $data);
 	}

 	public function payment(Request $request){
 		
 		$data['page_title'] = "Paymment | Kal-Coffee";
		$data['page'] = "payment";
		$data['type'] = "training";
		$data['bank_name'] = Preference::where('name','bank_name')->pluck('value')->first();
        $data['iban'] = Preference::where('name','iban')->pluck('value')->first();
        $data['amount'] = 0;
        if($request->isMethod('post')){
	 		$formData = $request->all();
	 		$session_id = Session::get('session_id');
	 		$data['discount_code'] = $formData['discount_code'];
            $data['grand_total'] = $formData['grand_total'];
	 		if($formData['discount_code'] !=""){
	 			$coupon = Coupon::where(['code' => $formData['discount_code'], 'status' => '1'])->first(); 			
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
 	
 	public function delete_training($id = null){
		$data['cartData'] = DB::table('cart')->where(['id' => $id])->delete();
		return redirect('training_cart');
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
            // if($request->payment_method == 'pay'){
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
	 		if($data['payment_method'] == "pay"){
		 		$card = new Card;
		 		$card->user_id = $userDetails->id;
		 		$card->order_id = $orderId;
		 		$card->name_on_card = $data['name_on_card'];
		 		$card->cvv = $data['cvv'];
		 		$card->expiration = $data['expiration'];
		 		$card->card_number = $data['card_number'];
		 		$card->save();
	 		}
	 		$cartData = DB::table('cart')->where(['session_id' => $session_id, 'type' => 'training'])->get();
	 		$grand_total = 0;
	 		foreach ($cartData as $key => $c) {
	 			$cartPro = new OrderDetail; 
	 			$cartPro->order_id = $orderId;
	 			$cartPro->user_id = $userDetails->id;
	 			$cartPro->product_id = $c->product_id;
	 			$cartPro->product_name = $c->product_name;
	 			$cartPro->product_code = "";
	 			$cartPro->quantity = 1;
	 			$cartPro->price = $c->price;
	 			$cartPro->course_id = $c->course_id;
	 			$cartPro->level_id = $c->level_id;
	 			$cartPro->schedule_date = $c->schedule_date;
	 			$cartPro->schedule_id = $c->schedule_id;
	 			$cartPro->save();
	 			
	 		}

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
            $data["subject"]= "Invoice";
            //$message_body = "Your Order is Placed Successfully. Please find your order invoice below.";
            // $pdf = PDF::loadView('home.training_invoice', $data);

            // Mail::send('home.mail_message', $data, function($message)use($data,$pdf) {
            // $message->to($data["email"], $data["client_name"])
            // ->subject($data["subject"])
            // ->attachData($pdf->output(), "training_invoice.pdf");
            // });


	 		DB::table('cart')->where(['session_id' => $session_id])->delete();
	 		$this->destroySessions();
	 		
	 		$data['page_title'] = "Thankyou | Kal-Coffee";
	 		$data['page'] = 'thankyou';
	 		$data['bank_name'] = Preference::where('name','bank_name')->pluck('value')->first();
            $data['iban'] = Preference::where('name','iban')->pluck('value')->first();
 	 		return view('home/thankyou', $data);
	    }
	    return redirect('/'); 		
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
