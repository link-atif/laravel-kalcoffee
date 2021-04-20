<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\order_item_requested;
use App\User;
use Auth;
use Session;
use App\Order;
use App\Cart;
use App\OrderDetail;
use App\Preference;
use Illuminate\Support\Facades\DB;



class UsersController extends Controller{

	public function register_user(Request $request){
		if($request->isMethod('post')){
			$data = request()->validate([
                'name' => 'required',
                'country' => 'required',
                'city' => 'required',
                'phone_number' => 'required',
                'email'    => 'required|email|max:255|unique:users',
            	'password' => 'required|min:6',
            ]);

			$data = $request->all();
			$user = new User;
    		$user->name = $data['name'];
    		$user->email = $data['email'];
    		$user->phone_number = $data['phone_number'];
    		$user->address_1 = $data['address_1'];
    		$user->address_2 = $data['address_2'];
    		$user->country = $data['country'];
    		$user->city = $data['city'];
    		$user->dealing_as = $data['dealing_as'];
    		$user->entity_age = $data['entity_age'];
    		$user->password = bcrypt($data['password']);
    		$user->type = "business";
    		$user->save();
    		return redirect()->back()->with('flash_message_success','You have registered Successfully!');
		}

		$data['page_title'] = "Kal-Coffee | Register";
		$data['page'] = "Register";
		$data['countries'] = DB::table('countries')->get();
        return view('home.register_user', $data);
	}

    
	

	public function register_trainee(Request $request){
		if($request->isMethod('post')){
			$data = request()->validate([
                'trainee_name' => 'required',
                'country' => 'required',
                'city' => 'required',
                'phone_number' => 'required',
                'email'    => 'required|email|max:255|unique:users',
            	'password' => 'required|min:6',
            ]);

			$data = $request->all();
			$user = new User;
    		$user->name = $data['trainee_name'];
    		$user->email = $data['email'];
    		$user->phone_number = $data['phone_number'];
    		$user->country = $data['country'];
    		$user->city = $data['city'];
    		$user->password = bcrypt($data['password']);
    		$user->type = "trainee";
    		$user->interests = implode(',', $data['interests']);
    		$user->save();
    		return redirect()->back()->with('flash_message_success','You have registered Successfully!');
		}

		$data['page_title'] = "Kal-Coffee | Register";
		$data['page'] = "Register";
        $data['countries'] = DB::table('countries')->get();
		return view('home.register_trainee', $data);
	}

    public function updateUserDetails(Request $request){
        if($request->isMethod('post')){
            $data = request()->validate([
                'name' => 'required',
                'phone_number' => 'required',
            ]);
            if($request->password){
                $data = request()->validate([
                    'password' => 'required|min:6',
                ]); 
            }

            $data = $request->all();
            $newArray = array(
                'name' => $data['name'],
                'phone_number' => $data['phone_number']
            );
            if($request->password){
                $newArray['password'] = bcrypt($data['password']);
            }
            User::where(['id' => \Auth::id()])->update($newArray);
            return redirect()->back()->with('flash_message_success','Updated Successfully!');
        }

    }

	public function login(Request $request){
        $page_title = "Login";
        if($request->isMethod('post')){
			$data = $request->input();            
            if(isset($data['login'])){
                $val = Session::put('login_redirect',$data['login']);
                return view('home.login_user')->with(compact('page_title'));
            }
			if(Auth::Attempt(['email'=> $data['email'], 'password' => $data['password']])){
				//Session::put('frontlogin',$data['email']);
				$val = Session::get('login_redirect');
                if(!empty($val)){
                    Session::put('login_redirect',"");
                    return redirect()->route($val);
                }                
                return redirect('/');
			}else{
				return redirect()->back()->with('flash_message_error','Invalid Email or Password!');
			}
		}
		/*if(Session::has('email')){
			return redirect('admin/dashboard');
		}*/
		return view('home.login_user')->with(compact('page_title'));
	}

	public function logout(){
		Session::flush();

		return redirect('/');
	}

    public function dashboard(){
                $data['page_title'] = "Dashboard | Kal-Coffee";
        $data['page'] = "dashboard";
        $data['user'] = Auth::user();
        $data['orders'] = Order::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->paginate(8);
        //dd($data);
        
        return view('home.dashboard', $data);
    }
    
    public function trainee_dashboard(){
                $data['page_title'] = "Dashboard | Kal-Coffee";
        $data['page'] = "dashboard";
        $data['user'] = Auth::user();
        $data['orders']  = OrderDetail::where('user_id', Auth::user()->id)->where('course_id','>',0)->orderBy('id', 'DESC')->paginate(8);
        //dd($data);
        
        return view('home.trainee_dashboard', $data);
    }

       public function details($id){
        //dd($id);
        //$data['order_id']=$id;

        $data['page_title'] = "Details | Kal-Coffee";
        $data['page'] = "view_details";
        $data['user'] = Auth::user();
        //$data['remaining']=order_item_requested::where('order_id',$id)->latest()->first();
        $data['orders'] = OrderDetail::where('user_id', \Auth::id())->where('order_id',$id)->get();
    
      //dd($data);

        // $data['page_title'] = "Invoice | Orders";
        // $data['orders'] = DB::table('orders')
        // ->join('order_details','order_details.order_id','=','orders.id')
        // ->join('order_item_requesteds','order_item_requesteds.order_id','=','orders.id')
        // ->join('users','users.id','=','orders.user_id')
        // ->select('order_details.product_name','order_details.product_code','order_details.price','order_details.quantity','orders.user_id','order_details.bag_size','orders.grand_total','order_item_requesteds.remaining','order_details.product_id','order_details.order_id','order_item_requesteds.created_at')
        // ->where('order_details.user_id', Auth::user()->id)
        // ->where('order_details.order_id',$id)
        // ->where('remaining','>',0)->latest()->first();

        //->where('schedule_id',$id)

        // ->get();


        //dd($data);
        return view('home.view_details', $data);
    }

    public function my_trainings(){
        $data['page_title'] = "My Trainings | Kal-Coffee";
        $data['page'] = "trainings";
        
        //$data['orders'] = Order::where('user_id', Auth::user()->id)->find(1)->order_details;
        $data['orders']  = OrderDetail::where('user_id', Auth::user()->id)->where('course_id','>',0)->orderBy('id', 'DESC')->get();
        return view('home.my-trainings', $data);      
    }

    public function register_as_plantool(Request $request){
        if($request->isMethod('post')){
            $data = request()->validate([
                'name' => 'required',
                'country' => 'required',
                'city' => 'required',
                'phone_number' => 'required',
                'email'    => 'required|email|max:255|unique:users',
                'password' => 'required|min:6',
            ]);

            $data = $request->all();
            $user = new User;
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->phone_number = $data['phone_number'];
            $user->address_1 = $data['address_1'];
            $user->address_2 = $data['address_2'];
            $user->country = $data['country'];
            $user->city = $data['city'];
            $user->dealing_as = $data['dealing_as'];
            $user->entity_age = $data['entity_age'];
            $user->password = bcrypt($data['password']);
            $user->type = "user";
            $user->save();

            Auth::Attempt(['email'=> $data['email'], 'password' => $data['password']]);
            if($data['entity_age'] == 'new'){
                return redirect(route('plan.tool.new'))->with('flash_message_error','Registered Successfully!');
            }
            if($data['entity_age'] == 'existing'){
                return redirect(route('plan.tool'))->with('flash_message_error','Registered Successfully!');
            }
        }

        $data['page_title'] = "Kal-Coffee | Register";
        $data['page'] = "Register";
        $data['countries'] = DB::table('countries')->get();
        return view('home.register_plantool', $data);
    }

    public function getCitiesList(Request $request){
        $cities = DB::table("cities")
                    ->where("country_code",$request->code)
                    ->get();
        return \Response::json($cities);
    }

}
