<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\DB;
class CategoryController extends Controller
{
	public function addCategory(Request $request){
    	if($request->isMethod('post')){
    		$data = request()->validate([
                'category_name' => 'required'
            ]);

            $data = $request->all();
    		//echo "<pre>"; print_r($data); die;
    		$category = new Category;

    		$category->name = $data['category_name'];
            $category->parent_id = 0;
    		$category->description = $data['description'];
    		$category->url = "";
    		$category->status = 0;
            $category->save();
    		return redirect('/admin/view-categories')->with('flash_message_success','Category added Successfully!');
    	}

        //$levels = Category::where(['parent_id'=>0])->get();
        $page_title = "Add Category";
    	return view('admin.add_category')->with(compact('page_title'));
    }

    public function editCategory(Request $request, $id = null){
        if($request->isMethod('post')){
            $data = request()->validate([
                'category_name' => 'required'
            ]);
            
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            Category::where(['id'=>$id])->update(['name'=>$data['category_name'],'description'=>$data['description'],'url'=>'']);
            return redirect('/admin/view-categories')->with('flash_message_success','Category updated Successfully!');
        }
        $categoryDetails = Category::where(['id'=>$id])->first();        
        $page_title = "Edit Category";
        //$levels = Category::where(['parent_id'=>0])->get();
        return view('admin.edit_category')->with(compact('categoryDetails','page_title'));
    }

    public function deleteCategory(Request $request, $id = null){
        if(!empty($id)){
            Category::where(['id'=>$id])->delete();
            return redirect()->back()->with('flash_message_success','Category deleted Successfully!');
        }
    }

    public function viewCategories(){

    	$categories = DB::table('categories')->paginate(10);
        //$categories = json_decode(json_encode($categories));

    	//echo "<pre>"; print_r($categories); die;
    	$page_title = "Categories";
    	return view('admin.view_categories')->with(compact('categories','page_title'));
    }
    //
}
