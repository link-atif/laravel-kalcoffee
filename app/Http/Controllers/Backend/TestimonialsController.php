<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Session;
use Image;
use App\Testimonial;

class TestimonialsController extends Controller
{
    public function addTestimonial(Request $request){
    	if($request->isMethod('post')){
            $data = request()->validate([
                'testimonial_name' => 'required',
                'testimonial_position' => 'required',
                'text' => 'required'
            ]);

    		$data = $request->all();
    		$testimonials = new Testimonial;
    		$testimonials->testimonial_name = $data['testimonial_name'];
    		$testimonials->testimonial_position = $data['testimonial_position'];
    		$testimonials->text = $data['text'];    		
    		$testimonials->save();

            return redirect('admin/view-testimonials')->with('flash_message_success','Testimonial has been added successfully!');
    	}
    	$page_title = "Add Testimonial";
    	return view('admin.add_testimonial')->with(compact('page_title'));
    }

    public function viewTestimonials(){
        $testimonials = DB::table('testimonials')->paginate(10);
        $page_title = "Testimonials";
        return view('admin.view_testimonials')->with(compact('testimonials','page_title'));
    }

    public function editTestimonial(Request $request, $id = null){
        if($request->isMethod('post')){
            $data = request()->validate([
                'testimonial_name' => 'required',
                'testimonial_position' => 'required',
                'text' => 'required'
            ]);
            
            $data = $request->all();
            $newArray = array(
                'testimonial_name' => $data['testimonial_name'],
                'testimonial_position' => $data['testimonial_position'],
            	'text' => $data['text']
            );

            Testimonial::where(['id'=>$id])->update($newArray);
            return redirect('/admin/view-testimonials')->with('flash_message_success','Testimonial details updated Successfully!');
        }

        $page_title = "Edit Testimonial";
        $testimonialDetails = Testimonial::where(['id'=>$id])->first();        
        return view('admin.edit_testimonial')->with(compact('testimonialDetails','page_title'));
    }

    public function deleteTestimonial(Request $request, $id = null){
        if(!empty($id)){
            Testimonial::where(['id'=>$id])->delete();
            return redirect()->back()->with('flash_message_success','Testimonial deleted Successfully!');
        }
    }
}
