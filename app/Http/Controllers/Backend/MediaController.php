<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use File;
use Auth;
use Session;
use Image;
use App\Media;

class MediaController extends Controller
{
    public function addMedia(Request $request){
    	if($request->isMethod('post')){
    		$data = request()->validate([
                'title' => 'required',
                'link' => 'required',
                'description' => 'required',
                'file' => 'required'
            ]);

            $data = $request->all();
    		$media = new Media;
    		$media->title = $data['title'];
    		$media->link = $data['link'];
    		$media->description = $data['description'];
    		// Upload Image
    		if($request->hasFile('file')){
    			$image_tmp = $request->file; //Input::file('image');
    			if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $image_path = 'images/admin/media/'.$filename;
                    Image::make($image_tmp)->save($image_path);
                    $media->file = $filename;
                }
    		}

    		$media->save();
    		/*return redirect()->back()->with('flash_message_success','Media has been added successfully!');*/
            return redirect('admin/view-media')->with('flash_message_success','Media has been added successfully!');
    	}
    	$page_title = "Add Media";
    	return view('admin.add_media')->with(compact('categories','page_title'));
    }

    public function viewMedia(){
        $media = DB::table('media')->paginate(10);
        $page_title = "Media";
        return view('admin.view_media')->with(compact('media','page_title'));
    }

    public function editMedia(Request $request, $id = null){
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
                    $image_path = 'images/admin/media/'.$filename;
                    Image::make($image_tmp)->save($image_path);

                    $newArray['file'] = $filename;
                    
                }
            }

            Media::where(['id'=>$id])->update($newArray);
            return redirect('/admin/view-media')->with('flash_message_success','Media updated Successfully!');
        }

        $page_title = "Edit Media";
        $mediaDetails = Media::where(['id'=>$id])->first();                
        return view('admin.edit_media')->with(compact('mediaDetails','page_title'));
    }

    public function deleteMedia(Request $request, $id = null){
        if(!empty($id)){
        	$file = Media::where(['id'=>$id])->pluck('file')->first();
        	$path = public_path().'/images/admin/media/'.$file.'/'.$file;
	      	if(File::exists($path)){
	          File::deleteDirectory('images/admin/media/'.$file);
	      	}
            Media::where(['id'=>$id])->delete();
            return redirect()->back()->with('flash_message_success','Media deleted Successfully!');
        }
    }
}
