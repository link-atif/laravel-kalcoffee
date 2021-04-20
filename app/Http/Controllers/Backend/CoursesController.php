<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Session;
use Image;
use App\Courses;
use App\Schedule;
use App\Level;
use App\OrderDetail;
use App\User;
use Carbon\Carbon;

class CoursesController extends Controller
{
    public function addCourse(Request $request){
        if($request->isMethod('post')){
            $data = request()->validate([
                'name' => 'required',
                'location'=>'required',
                'description' => 'required',
                /*'start_date' => 'required',
                'end_date' => 'required',*/
                'image' => 'required',
                'trainer' => 'required'
            ]);

            $data = $request->all();
            $courses = new Courses;
            $courses->name = $data['name'];
            $courses->location = $data['location'];
            $courses->description = $data['description'];
            $courses->start_date = Carbon::today()->toDateString(); //$data['start_date'];
            $courses->end_date = Carbon::today()->toDateString(); //$data['end_date']; //Carbon\Carbon::parse($data['end_date'])->format('d/m/Y');
            // Upload Image
            if($request->hasFile('image')){
                $image_tmp = $request->image; //Input::file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $image_path = 'images/admin/courses/'.$filename;
                    Image::make($image_tmp)->save($image_path);
                    $courses->image = $filename;
                }
            }
            $courses->trainer = $data['trainer'];
            $courses->save();

            return redirect('admin/view-courses')->with('flash_message_success','Course has been added successfully!');


        }
        $data['page_title'] = "Add Course";
        $data['users'] = User::orderBy('id','DESC')->where('type','=','trainer')->get();
        return view('admin.add_course', $data);

       
    }

    public function viewCourses(){
        $courses = DB::table('courses')->orderBy('id', 'DESC')->paginate(10);
        $page_title = "Courses";
        return view('admin.view_courses')->with(compact('courses','page_title'));
    }  

     public function viewCourseDetails(Request $request, $id){
        //dd($id);

         $data['courses'] = DB::table('order_details')
      ->join('courses','courses.id','=','order_details.course_id')
      ->join('schedules','schedules.id','=','order_details.schedule_id')
      ->select('courses.*','order_details.schedule_date')
      ->where('order_details.course_id',$id)
      ->orderBy('id', 'DESC')->paginate(5);
     // dd($data);
        //$data['courses'] = DB::table('courses')->paginate(10);
        $data['page_title'] = "Courses";
        return view('admin.view_coursesSchedules',$data);
    }

     

    //   $data['mail'] = DB::table('orders')
    //   ->join('order_details','order_details.order_id','=','orders.id')
    //   ->select('orders.*','order_details.schedule_id as a_id','orders.grand_total','order_details.user_id','order_details.schedule_date')
    //   ->where('order_details.schedule_id',$id)
    //   ->paginate(10);
    //   $a_id=OrderDetail::where('schedule_id',$id)->pluck('course_id')->first();
    //   //dd( $a_id);
    //   $data['page_title'] = "Attendies Details | Kal-Coffee";
    //    $data['course_name'] =  courses::where('id', $a_id)->pluck('name')->first();
    //   return view('admin/view_attendies',$data);
    // }

    public function editCourse(Request $request, $id = null){
        if($request->isMethod('post')){
            $data = request()->validate([
                'name' => 'required',
                'description' => 'required',
                /*'start_date' => 'required',
                'end_date' => 'required'*/
            ]);

            $data = $request->all();
            $newArray = array(
                'name' => $data['name'],
                'description' => $data['description'],
                /*'start_date' => $data['start_date'],
                'end_date' => $data['end_date']*/
            );

            if($request->hasFile('image')){
                $image_tmp = $request->image; //Input::file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $image_path = 'images/admin/courses/'.$filename;
                    // Resize Images
                    Image::make($image_tmp)->save($image_path);
                    //Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
                    //Image::make($image_tmp)->resize(300,300)->save($small_image_path);

                    // Store image name in products table
                    $newArray['image'] = $filename;
                }
            }

            courses::where(['id'=>$id])->update($newArray);
            return redirect('/admin/view-courses')->with('flash_message_success','Courses details updated Successfully!');
        }

        $data['page_title'] = "Edit Training Course";
        $data['detail'] = Courses::where(['id'=>$id])->first();        
        return view('admin.edit_course', $data);
    }

    public function deleteCourse(Request $request, $id = null){
        if(!empty($id)){
            Courses::where(['id'=>$id])->delete();
            return redirect()->back()->with('flash_message_success','Course deleted Successfully!');
        }
    }


    ////////////////////// Levels   //////////////////////////////

    public function addLevel(Request $request){
        if($request->isMethod('post')){
            $data = request()->validate([
                'name' => 'required',
                'course_id' => 'required'
            ]);

            $data = $request->all();
            $level = new Level;
            $level->course_id = $data['course_id'];
            $level->name = $data['name'];
            $level->description = $data['description'];
            $level->price = $data['price'];
            $level->points = $data['points'];
            $level->duration = $data['duration'];
            $level->save();

            return redirect('admin/view-levels')->with('flash_message_success','Level has been added successfully!');
        }

        $data['page_title'] = "Add Level";
        $data['courses'] = Courses::orderBy('id','DESC')->get();
        return view('admin.add_level', $data);
    }

    public function viewLevels(){
        $data['levels'] = Level::orderBy('id','DESC')->paginate(10);
        $data['page_title'] = "Levels";
        return view('admin.view_levels', $data);
    }

    public function editLevel(Request $request, $id = null){
        if($request->isMethod('post')){
            $data = request()->validate([
                'name' => 'required',
                'course_id' => 'required'
            ]);

            $data = $request->all();
            $newArray = array(
                'course_id' => $data['course_id'],
                'name' => $data['name'],
                'description' => $data['description'],             
                'price' => $data['price'],
                'points' => $data['points'],
                'duration' => $data['duration'],
            );

            Level::where(['id'=>$id])->update($newArray);
            return redirect('/admin/view-levels')->with('flash_message_success','Level details updated Successfully!');
        }

        $data['page_title'] = "Edit Level";
        $data['detail'] = Level::where(['id'=>$id])->first();        
        $data['courses'] = Courses::orderBy('id','DESC')->get();
        return view('admin.edit_level', $data);
    }

    public function deleteLevel(Request $request, $id = null){
        if(!empty($id)){
            Level::where(['id'=>$id])->delete();
            return redirect()->back()->with('flash_message_success','Level deleted Successfully!');
        }
    }


    ////////////////////// End Levels /////////////////////////////

    public function addSchedule(Request $request){
        if($request->isMethod('post')){
            $data = request()->validate([
                'course_id' => 'required',
                'level_id' => 'required',
                'schedule_date' => 'required',
            ]);

            $data = $request->all();
            $result =  Schedule::where(['course_id'=> $data['course_id'], 'level_id'=> $data['level_id'], 'schedule_date' => $data['schedule_date']])->first();
            if(is_null($result)){
                $schedule = new Schedule;
                $schedule->course_id = $data['course_id'];
                $schedule->level_id = $data['level_id'];
                $schedule->schedule_date = $data['schedule_date'];
                $schedule->save();
                return redirect('admin/view-schedules')->with('flash_message_success','Schedule has been added successfully!');
            }else{
                return redirect(route('add.schedule'))->with('flash_message_error','Schedule already exists!');
            }
        }
        $data['courses'] = Courses::orderBy('id','ASC')->get();
        $data['levels'] = Level::orderBy('id','ASC')->get();
        $data['page_title'] = "Add Schedule";
        return view('admin.add_schedule', $data);
    }

    public function viewSchedules(){
        $data['detail'] = Schedule::orderBy('id','DESC')->paginate(10); 
        //dd($data['detail']);
          /*$od = OrderDetail::where('schedule_id !=', 'null')->pluck('schedule_id')->toArray();
            $unique = array_count_values($od); 
             dd($unique);
            $i =1;
            foreach ($od as   $key => $o ) {
              //dd($o); 
                $data['co'][$i] = DB::table('order_details')
                ->join('courses','courses.id','=','order_details.course_id')
                ->join('users','users.id','=','order_details.user_id')
                ->select('order_details.user_id','courses.*','order_details.schedule_id as a_id')
                ->where('order_details.schedule_id',$o)
                ->get()
                ->count('order_details.order_id');
                 $i++;
            }   */    
        $data['page_title'] = "Schedule";
        //dd($data['co']);
        return view('admin.view_schedules',$data);
    }

    public function editSchedule(Request $request, $id = null){
        if($request->isMethod('post')){
            $data = request()->validate([
                'course_id' => 'required',
                'level_id' => 'required',
                'schedule_date' => 'required'
            ]);

            $data = $request->all();
            $newArray = array(
                'course_id' => $data['course_id'],
                'level_id' => $data['level_id'],
                'schedule_date' => $data['schedule_date']
            );

            Schedule::where(['id'=>$id])->update($newArray);
            return redirect('/admin/view-schedules')->with('flash_message_success','Schedule details updated Successfully!');
        }

        $data['page_title'] = "Edit Schedule";
        $data['detail'] = Schedule::where(['id'=>$id])->first();
        $data['courses'] = Courses::orderBy('id','ASC')->get();
        $data['levels'] = Level::orderBy('id','ASC')->get();
        return view('admin.edit_schedule',$data);
    }

    public function deleteSchedule(Request $request, $id = null){
        if(!empty($id)){
            Schedule::where(['id'=>$id])->delete();
            return redirect()->back()->with('flash_message_success','Schedule deleted Successfully!');
        }
    }

    public function loadLevel(Request $request){
        $level =  Level::where(['course_id'=> $request->id])->get();
        return \Response::json($level);
    }
}
