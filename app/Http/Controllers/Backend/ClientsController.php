<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use File;
use Auth;
use Session;
use Image;
use App\Client;

class ClientsController extends Controller{

    public function addClient(Request $request){
    	if($request->isMethod('post')){
    		$data = request()->validate([
                'name' => 'required',
                'description' => 'required',
                'file' => 'required|mimes:jpg,jpeg,png,bmp,tiff'
            ]);

            $data = $request->all();
    		$client = new Client;
    		$client->name = $data['name'];
    		$client->description = $data['description'];

    		// Upload Image
    		if($request->hasFile('file')){
    			$image_tmp = $request->file; //Input::file('image');
    			if($image_tmp->isValid()){
    				$extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $image_path = 'images/admin/clients/'.$filename;
                    Image::make($image_tmp)->save($image_path);
                    $client->file = $filename;
                }
    		}

    		$client->save();
            return redirect('admin/view-clients')->with('flash_message_success','Client has been added successfully!');
    	}
    	$page_title = "Add Client";
    	return view('admin.add_client')->with(compact('categories','page_title'));
    }

    public function viewClients(){
        $client = DB::table('clients')->paginate(10);
        $page_title = "Clients";

        return view('admin.view_clients')->with(compact('client','page_title'));
    }

    public function editClient(Request $request, $id = null){
        if($request->isMethod('post')){
            $data = request()->validate([
                'name' => 'required',
                'description' => 'required'
            ]);

            $data = $request->all();
            $newArray = array(
                'name' => $data['name'],
            	'description' => $data['description']
            );

            // Upload Image
            if($request->hasFile('file')){
                $image_tmp = $request->file; //Input::file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $image_path = 'images/admin/clients/'.$filename;
                    Image::make($image_tmp)->save($image_path);
                    $newArray['file'] = $filename;
                }
            }

            Client::where(['id'=>$id])->update($newArray);
            return redirect('/admin/view-clients')->with('flash_message_success','Client updated Successfully!');
        }

        $page_title = "Edit Client";
        $clientDetails = Client::where(['id'=>$id])->first();                
        return view('admin.edit_client')->with(compact('clientDetails','page_title'));
    }

    public function deleteClient(Request $request, $id = null){
        if(!empty($id)){
        	$file = Client::where(['id'=>$id])->pluck('file')->first();
        	$path = public_path().'/images/admin/clients/'.$file.'/'.$file;
	      	if(File::exists($path)){
	          File::deleteDirectory('images/admin/clients/'.$file);
	      	}
            Client::where(['id'=>$id])->delete();
            return redirect()->back()->with('flash_message_success','Client deleted Successfully!');
        }
    }

}


