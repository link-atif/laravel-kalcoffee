<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Session;
use Image;
use App\News;

class NewsController extends Controller
{
    public function addNews(Request $request){
    	if($request->isMethod('post')){
    		$data = request()->validate([
                'title' => 'required',
                'link' => 'required',
                'image' => 'required'
            ]);

            $data = $request->all();
    		$news = new News;
    		$news->title = $data['title'];
    		$news->link = $data['link'];
    		// Upload Image
    		if($request->hasFile('image')){
    			$image_tmp = $request->image; //Input::file('image');
    			if($image_tmp->isValid()){
    				$extension = $image_tmp->getClientOriginalExtension();
    				$filename = rand(111,99999).'.'.$extension;
    				$image_path = 'images/admin/news/'.$filename;
    				// Resize Images
    				Image::make($image_tmp)->save($image_path);
    				//Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
    				//Image::make($image_tmp)->resize(300,300)->save($small_image_path);

    				// Store image name in products table
    				$news->image = $filename;
    			}
    		}
    		$news->save();

            return redirect('admin/view-news')->with('flash_message_success','News has been added successfully!');
    	}
    	$page_title = "Add News";
    	return view('admin.add_news')->with(compact('page_title'));
    }

    public function viewNews(){
        $news = DB::table('news')->paginate(10);
        $page_title = "News";
        return view('admin.view_news')->with(compact('news','page_title'));
    }

    public function editNews(Request $request, $id = null){
        if($request->isMethod('post')){
            $data = request()->validate([
                'title' => 'required',
                'link' => 'required'
            ]);

            $data = $request->all();
            $newArray = array(
                'title' => $data['title'],
                'link' => $data['link']
            );

            if($request->hasFile('image')){
                $image_tmp = $request->image; //Input::file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $image_path = 'images/admin/news/'.$filename;
                    // Resize Images
                    Image::make($image_tmp)->save($image_path);
                    //Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
                    //Image::make($image_tmp)->resize(300,300)->save($small_image_path);

                    // Store image name in products table
                    $newArray['image'] = $filename;
                }
            }

            News::where(['id'=>$id])->update($newArray);
            return redirect('/admin/view-news')->with('flash_message_success','News details updated Successfully!');
        }

        $page_title = "Edit News";
        $newsDetails = News::where(['id'=>$id])->first();        
        return view('admin.edit_news')->with(compact('newsDetails','page_title'));
    }

    public function deleteNews(Request $request, $id = null){
        if(!empty($id)){
            News::where(['id'=>$id])->delete();
            return redirect()->back()->with('flash_message_success','News deleted Successfully!');
        }
    }
}
