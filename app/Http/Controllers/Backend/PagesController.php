<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Session;
use Image;
use App\Page;
class PagesController extends Controller
{
    public function addPages(Request $request){

    	if($request->isMethod('post')){
    		$data = request()->validate([
                'title' => 'required',
                'type' => 'required'
            ]);

            $data = $request->all();
    		$pages = new Page;
    		$pages->title = $data['title'];
    		$pages->type = $data['type'];
    		$pages->slug = make_slug($data['title']);
    		$pages->body = (!empty($data['body'])) ? $data['body'] : "";
    		$pages->sort_order = $data['sort_order'];
    		$pages->save();

            return redirect('admin/view-pages')->with('flash_message_success','Pages has been added successfully!');
    	}
    	$page_title = "Add Pages";
    	return view('admin.add_pages')->with(compact('page_title'));
    }

    public function viewPages(){
        $pages = DB::table('pages')->paginate(10);
        $page_title = "Pages";
        return view('admin.view_pages')->with(compact('pages','page_title'));
    }

    public function editPages(Request $request, $id = null){
        if($request->isMethod('post')){
            $data = request()->validate([
                'title' => 'required',
                'type' => 'required'
            ]);
            
            $data = $request->all();
            $newArray = array(
                'title' => $data['title'],
                'type' => $data['type'],
                'slug' => make_slug($data['title']),
                'body' => (!empty($data['body'])) ? $data['body'] : "",
                'sort_order' => $data['sort_order']
            );

            Page::where(['id'=>$id])->update($newArray);
            return redirect('/admin/view-pages')->with('flash_message_success','Pages updated Successfully!');
        }

        $page_title = "Edit Pages";
        $pagesDetails = Page::where(['id'=>$id])->first();        
        return view('admin.edit_pages')->with(compact('pagesDetails','page_title'));
    }

    public function deletePages(Request $request, $id = null){
        if(!empty($id)){
            Page::where(['id'=>$id])->delete();
            return redirect()->back()->with('flash_message_success','Pages deleted Successfully!');
        }
    }
}
