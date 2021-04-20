<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Certificate;

class CertificatesController extends Controller
{
    public function addCertificate(Request $request){
    	if($request->isMethod('post')){
    		$data = request()->validate([
                'certificate_name' => 'required',
            ]);

            $data = $request->all();
    		$certificate = new Certificate;
    		$certificate->certificate_name = $data['certificate_name'];
    		$certificate->save();
            return redirect()->route('view.certificates')->with('flash_message_success','Certificate has been added successfully!');
    	}

    	$data['page_title'] = "Add Certificate";
    	return view('admin.add_certificate',$data);
    }

    public function viewCertificates(){
        $data['certificates'] = DB::table('certificates')->paginate(10);
        $data['page_title'] = "Certificates";
        return view('admin.view_certificates',$data);
    }

    public function editCertificate(Request $request, $id = null){
        if($request->isMethod('post')){
            $data = request()->validate([
                'certificate_name' => 'required',
            ]);

            $data = $request->all();
            $newArray = array(
                'certificate_name' => $data['certificate_name'],
            );
            Certificate::where(['id'=>$id])->update($newArray);
            return redirect()->route('view.certificates')->with('flash_message_success','Certificate updated Successfully!');
        }

        $data['page_title'] = "Edit Certificate";
        $data['certificateDetails'] = Certificate::where(['id'=>$id])->first();        
        return view('admin.edit_certificate',$data);
    }

    public function deleteCertificate(Request $request, $id = null){
        if(!empty($id)){
            Certificate::where(['id'=>$id])->delete();
            return redirect()->back()->with('flash_message_success','Certificate deleted Successfully!');
        }
    }
}
