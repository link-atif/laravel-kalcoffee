<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Support\Facades\DB;
use App\Mail;
use App\Schedule;
use App\Order;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MailController extends Controller {
  public function basic_email() {
    $data = array('name'=>"Kal-Coffee");
    Mail::send(['text'=>'mail'], $data, function($message) {
       $message->to('engineerlife021@gmail.com', 'Tutorials Point')->subject
          ('Laravel Basic Testing Mail');
       $message->from('ghulamali5230@gmail.com','Kal-Coffee');
    });
    echo "Basic Email Sent. Check your inbox.";
  }
  public function html_email() {
    $data = array('name'=>"Kal-Coffee");
    Mail::send('mail', $data, function($message) {
       $message->to('engineerlife021@gmail.com', 'Tutorials Point')->subject
          ('Laravel HTML Testing Mail');
       $message->from('ghulamali5230@gmail.com','Kal-Coffee');
    });
    echo "HTML Email Sent. Check your inbox.";
  }

   /*extra
   
    $mail = DB::table('orders')
   
			
			->join('schedules','schedules.schedules_id','=','orders.schedules_id')
			->join('orders','orders.user_email','=','schedules.user_email')
			->select('order.user_email','schedules.schedules_id')
			->where('schedule.id', $id)
			->get();

   public function attachment_email() {
      $data = array('name'=>"Kal-Coffee");
      Mail::send('mail', $data, function($message) {
         $message->to('engineerlife021@gmail.com', 'Tutorials Point')->subject
            ('Laravel Testing Mail with Attachment');
         $message->attach('C:\laravel-master\laravel\public\uploads\image.png');
         $message->attach('C:\laravel-master\laravel\public\uploads\test.txt');
         $message->from('xyz@gmail.com','Virat Gandhi');
      });
      echo "Email Sent with attachment. Check your inbox.";
   }*/
    
    ////////////////////Done by G.Ali/////////////////////
    //view mail page
    public function addmail(Schedule $mail,$id){
      $schedule=Schedule::find($id);

      $mail = DB::table('orders')
      ->join('order_details','order_details.order_id','=','orders.id')
      ->select('orders.user_email','order_details.schedule_id')
      ->where('schedule_id',$id)
      ->get();
      $page_title = "Mail";
      return view('admin.add_mail')->with(compact('mail','page_title'));
    }

        public function attendiesDetails(Schedule $mail,$id){


      $schedule=Schedule::find($id);

      $mail = DB::table('orders')
      ->join('order_details','order_details.order_id','=','orders.id')
      ->select('orders.user_email','order_details.schedule_id')
      ->where('schedule_id',$id)
      ->get();
      $page_title = "Mail";
      return view('admin/view_attendies')->with(compact('mail','page_title'));
    }






   //Add mail
   public function savemail(Request $request){       
    if($request->isMethod('post')){
      $request->validate([
          'message' => 'required',
      ]);

      $input = $request->all();
      $input['mails'] = $request->input('mails');
      Mail::create($input);
        $data = array('name'=>"Kal-Coffee");
        \Mail::send('admin/view_mail',$data, function($message) {
        $query = Mail::orderBy('created_at','desc')->first();
        $last=$query->mails;
        //
        //dd($last);
          foreach ($last as $mail )
            {
              $message->to($mail); 
            }  
              $message->from('ghulamali5230@gmail.com','Kal-Coffee');
          });
        return redirect('admin/view-schedules')->with('flash_message_success','Mail has been added successfully!');
      }
    }
        //view mail
  public function viewmail(){
    $query = Mail::orderBy('created_at','desc')->first();
     
    return view('admin.view_mail')->with(compact('query'));
  }
}