<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use File;
use Auth;
use Session;
use App\Service;

class ServicesController extends Controller{

	public function addService(Request $request){
    	if($request->isMethod('post')){
    		$data = request()->validate([
                'title' => 'required',
                'link' => 'required',
                'description' => 'required',
                'file' => 'required'
            ]);

            $data = $request->all();
    		$service = new Service;
    		$service->title = $data['title'];
    		$service->link = $data['link'];
    		$service->description = $data['description'];

    		// Upload Image
    		if($request->hasFile('file')){
    			$image_tmp = $request->file; //Input::file('image');
    			if($image_tmp->isValid()){
    				$extension = $image_tmp->getClientOriginalExtension();
    				$filename = rand(111,99999).'.'.$extension;
    				$image_path = 'images/admin/services/'.$filename;
    				$image_tmp->move($image_path, $filename);
    				// Resize Images
    				//Image::make($image_tmp)->save($image_path);
    				//Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
    				//Image::make($image_tmp)->resize(300,300)->save($small_image_path);

    				// Store image name in service table
    				$service->file = $filename;
    			}
    		}

    		$service->save();
    		/*return redirect()->back()->with('flash_message_success','Service has been added successfully!');*/
            return redirect('admin/view-services')->with('flash_message_success','Service has been added successfully!');
    	}
    	$page_title = "Add Service";
    	return view('admin.add_service')->with(compact('categories','page_title'));
    }

    public function viewServices(){
        $service = DB::table('services')->paginate(10);
        $page_title = "Service";
        return view('admin.view_services')->with(compact('service','page_title'));
    }

    public function editService(Request $request, $id = null){
        if($request->isMethod('post')){
            $data = request()->validate([
                'title' => 'required',
                'link' => 'required',
                'description' => 'required'
            ]);

            $data = $request->all();
            $newArray = array(
                'title' => $data['title'],
                'link' => $data['link'],
            	'description' => $data['description']
            );

            // Upload Image
            if($request->hasFile('file')){
                $image_tmp = $request->file; //Input::file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $image_path = 'images/admin/services/'.$filename;
                    $image_tmp->move($image_path, $filename);
                    // Resize Images
                    //Image::make($image_tmp)->save($image_path);
                    //Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
                    //Image::make($image_tmp)->resize(300,300)->save($small_image_path);

                    // Store image name in service table
                    $newArray['file'] = $filename;
                    $path = public_path().'/images/admin/service/'.$data['old_file'].'/'.$data['old_file'];
			      	if(File::exists($path)){
			          File::deleteDirectory('images/admin/service/'.$data['old_file']);
			          //File::delete('images/admin/service/'.$data['old_file']);
			      	}
                }
            }

            Service::where(['id'=>$id])->update($newArray);
            return redirect('/admin/view-services')->with('flash_message_success','Service updated Successfully!');
        }

        $page_title = "Edit Service";
        $serviceDetails = Service::where(['id'=>$id])->first();                
        return view('admin.edit_service')->with(compact('serviceDetails','page_title'));
    }

    public function deleteService(Request $request, $id = null){
        if(!empty($id)){
        	$file = Service::where(['id'=>$id])->pluck('file')->first();
        	$path = public_path().'/images/admin/services/'.$file.'/'.$file;
	      	if(File::exists($path)){
	          File::deleteDirectory('images/admin/services/'.$file);
	      	}
            Service::where(['id'=>$id])->delete();
            return redirect()->back()->with('flash_message_success','Service deleted Successfully!');
        }
    }
    
}
