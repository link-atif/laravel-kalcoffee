<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Process;

class ProcessesController extends Controller
{
    public function addProcess(Request $request){
    	if($request->isMethod('post')){
    		$data = request()->validate([
                'process_name' => 'required',
            ]);

            $data = $request->all();
    		$process = new Process;
    		$process->process_name = $data['process_name'];
    		$process->save();
            return redirect()->route('view.processes')->with('flash_message_success','Process has been added successfully!');
    	}

    	$data['page_title'] = "Add Processs";
    	return view('admin.add_process',$data);
    }

    public function viewProcesses(){
        $data['processes'] = DB::table('processes')->paginate(10);
        $data['page_title'] = "Process";
        return view('admin.view_processes',$data);
    }

    public function editProcess(Request $request, $id = null){
        if($request->isMethod('post')){
            $data = request()->validate([
                'process_name' => 'required',
            ]);

            $data = $request->all();
            $newArray = array(
                'process_name' => $data['process_name'],
            );
            Process::where(['id'=>$id])->update($newArray);
            return redirect()->route('view.processes')->with('flash_message_success','Process updated Successfully!');
        }

        $data['page_title'] = "Edit Process";
        $data['processDetails'] = Process::where(['id'=>$id])->first();        
        return view('admin.edit_process',$data);
    }

    public function deleteProcess(Request $request, $id = null){
        if(!empty($id)){
            Process::where(['id'=>$id])->delete();
            return redirect()->back()->with('flash_message_success','Process deleted Successfully!');
        }
    }
}
