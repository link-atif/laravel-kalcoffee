<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Variety;
class VarietiesController extends Controller
{
    public function addVariety(Request $request){
    	if($request->isMethod('post')){
    		$data = request()->validate([
                'variety_name' => 'required',
            ]);

            $data = $request->all();
    		$variety = new Variety;
    		$variety->variety_name = $data['variety_name'];
    		$variety->save();
            return redirect()->route('view.varieties')->with('flash_message_success','Variety has been added successfully!');
    	}

    	$data['page_title'] = "Add Variety";
    	return view('admin.add_variety',$data);
    }

    public function viewVarieties(){
        $data['varieties'] = DB::table('varieties')->paginate(10);
        $data['page_title'] = "Varieties";
        return view('admin.view_varieties',$data);
    }

    public function editVariety(Request $request, $id = null){
        if($request->isMethod('post')){
            $data = request()->validate([
                'variety_name' => 'required',
            ]);

            $data = $request->all();
            $newArray = array(
                'variety_name' => $data['variety_name'],
            );
            Variety::where(['id'=>$id])->update($newArray);
            return redirect()->route('view.varieties')->with('flash_message_success','Variety updated Successfully!');
        }

        $data['page_title'] = "Edit Variety";
        $data['varietyDetails'] = Variety::where(['id'=>$id])->first();        
        return view('admin.edit_variety',$data);
    }

    public function deleteVariety(Request $request, $id = null){
        if(!empty($id)){
            Variety::where(['id'=>$id])->delete();
            return redirect()->back()->with('flash_message_success','Variety deleted Successfully!');
        }
    }
}
