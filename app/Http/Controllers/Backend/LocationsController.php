<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Session;
use App\Location;

class LocationsController extends Controller{
	public function addLocation(Request $request){
    	if($request->isMethod('post')){
    		$data = request()->validate([
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'longitude' => 'required',
                'latitude' => 'required'
            ]);


            $data = $request->all();
    		$locations = new Location;
    		$locations->name = $data['name'];
    		$locations->email = $data['email'];
    		$locations->phone = $data['phone'];
    		$locations->address = $data['address'];  
    		$locations->longitude = $data['longitude'];  
    		$locations->latitude = $data['latitude'];  
    		$locations->save();

            return redirect('admin/view-locations')->with('flash_message_success','Location has been added successfully!');
    	}
    	$page_title = "Add Location";
    	return view('admin.add_location')->with(compact('page_title'));
    }

    public function viewLocations(){
        $locations = DB::table('locations')->paginate(10);
        $page_title = "Locations";
        return view('admin.view_locations')->with(compact('locations','page_title'));
    }

    public function editLocation(Request $request, $id = null){
        if($request->isMethod('post')){
            $data = request()->validate([
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'longitude' => 'required',
                'latitude' => 'required'
            ]);
            
            $data = $request->all();
            $newArray = array(
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'longitude' => $data['longitude'],
                'latitude' => $data['latitude']
            );

            Location::where(['id'=>$id])->update($newArray);
            return redirect('/admin/view-locations')->with('flash_message_success','Locations details updated Successfully!');
        }

        $page_title = "Edit Location";
        $locationDetails = Location::where(['id'=>$id])->first();        
        return view('admin.edit_location')->with(compact('locationDetails','page_title'));
    }

    public function deleteLocation(Request $request, $id = null){
        if(!empty($id)){
            Location::where(['id'=>$id])->delete();
            return redirect()->back()->with('flash_message_success','Location deleted Successfully!');
        }
    }
}
