<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Session;
use Auth;


use App\Order;
use App\OrderDetail;
use App\Trainer;


    

class TrainerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $users = DB::table('trainers')->paginate(10);
        $data['page_title'] = "Kal-Coffee | Register";
        $data['page'] = "Register";
        $data['countries'] = DB::table('countries')->get();
        return view('admin/add_trainer', $data);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->phone_number = $request->input('phone_number');
            $user->address_1 = $request->input('address_1');
            $user->address_2 = $request->input('address_2');
            $user->country = $request->input('country');
            $user->city = $request->input('city');
            $user->password = bcrypt($data['password']);
            $user->type = $request->input('type');
            $user->save();
            return redirect()->back()->with('flash_message_success','Trainer record deleted Successfully!');
            }
                
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Trainer  $trainer
     * @return \Illuminate\Http\Response
     */
    public function show(Trainer $trainer)
    {
        $users = DB::table('users')->where('type','=','trainer')->paginate(10);
        $page_title = "Trainers";
        return view('admin.view_trainer')->with(compact('users','page_title'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Trainer  $trainer
     * @return \Illuminate\Http\Response
     */
    public function edit(Trainer $trainer,$id)
    {
        $data['details'] = DB::table('users')->where('id',$id)->first();
        $data['page_title'] = "Edit Trainer";
        return view('admin.edit_trainer',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Trainer  $trainer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trainer $trainer ,$id)
    {

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
               'phone_number' => $data['phone_number'],
               'contact_name' => $data['contact_name'] ? $data['contact_name'] : "",
               'address_1' => $data['address_1'] ? $data['address_1'] : "",
               'address_2' => $data['address_2'] ? $data['address_2'] : ""
           );
           if($request->password){
               $newArray['password'] = bcrypt($data['password']);
           }
           User::where(['id' => $data['id']])->update($newArray);
           $users = DB::table('users')->where('type','=','trainer')->paginate(10);
        $page_title = "Trainers";
        return view('admin.view_trainer',compact('users','page_title'))->with('flash_message_success','Trainer record updated Successfully!');
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Trainer  $trainer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trainer $trainer,$id)
    {
         if(!empty($id)){
            Trainer::where(['id'=>$id])->delete();
            return redirect()->back()->with('flash_message_success','Trainer record deleted Successfully!');
        }
    }
}
