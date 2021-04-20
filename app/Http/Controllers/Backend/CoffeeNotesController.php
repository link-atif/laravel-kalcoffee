<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CoffeeNote;
use Illuminate\Support\Facades\DB;

class CoffeeNotesController extends Controller
{
    public function add(Request $request){
    	if($request->isMethod('post')){
    		$data = request()->validate([
                'type' => 'required',
                'name' => 'required'
            ]);

            $data = $request->all();
    		//echo "<pre>"; print_r($data); die;
    		$object = new CoffeeNote;

    		$object->name = $data['name'];
            $object->type = $data['type'];
            $object->save();
    		return redirect('/admin/view-coffee-notes')->with('flash_message_success','Coffee Note has been added Successfully!');
    	}
        $data['page_title'] = "Add Coffee Note";
    	return view('admin.coffeeNote.add', $data);
    }

    public function edit(Request $request, $id = null){
        if($request->isMethod('post')){
            $data = request()->validate([
                'type' => 'required',
                'name' => 'required'
            ]);
            
            $data = $request->all();
            CoffeeNote::where(['id'=>$id])->update(['name'=>$data['name'],'type'=>$data['type']]);
            return redirect('/admin/view-coffee-notes')->with('flash_message_success','Coffee Notes has been updated Successfully!');
        }
        $data['detail'] = CoffeeNote::where(['id'=>$id])->first();
        $data['page_title'] = "Edit Coffee Note";
        return view('admin.coffeeNote.edit', $data);
    }

    public function delete(Request $request, $id = null){
        if(!empty($id)){
            CoffeeNote::where(['id'=>$id])->delete();
            return redirect()->back()->with('flash_message_success','Coffee Note deleted Successfully!');
        }
    }

    public function view(){
    	$data['details'] = CoffeeNote::paginate(10);
    	$data['page_title'] = "Coffee Notes";
    	return view('admin.coffeeNote.view', $data);
    }
    
    public function loadNotes(Request $request){
        $data['notes'] =  CoffeeNote::where(['category_id'=> $request->id])->get();
    	$returnHTML = view('admin.coffeeNote.ajax-notes', $data)->render();
        return \Response::json(array('success' => true, 'html'=>$returnHTML));
    }

}
