<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use Session;
use App\Faq;

class FaqsController extends Controller
{
    public function addFaq(Request $request){
        if($request->isMethod('post')){
            $data = request()->validate([
                'question' => 'required',
                'answer' => 'required'
            ]);

            $data = $request->all();
            $faqs = new Faq;
            $faqs->question = $data['question'];
            $faqs->answer = $data['answer'];            
            if(!empty($data['answer'])){
                $faqs->save();
                return redirect('admin/view-faqs')->with('flash_message_success','Faq\'s has been added successfully!');
            }
    	}
    	$page_title = "Add Faq's";
    	return view('admin.add_faq')->with(compact('page_title'));
    }

    public function viewFaqs(){
        $faqs = DB::table('faqs')->paginate(10);
        $page_title = "Faqs";
        
        return view('admin.view_faqs')->with(compact('faqs','page_title'));
    }

    public function editFaq(Request $request, $id = null){
        if($request->isMethod('post')){
            $data = request()->validate([
                'question' => 'required',
                'answer' => 'required'
            ]);
            
            $data = $request->all();
            $newArray = array(
                'question' => $data['question'],
                'answer' => $data['answer']
            );
            Faq::where(['id'=>$id])->update($newArray);
            return redirect('/admin/view-faqs')->with('flash_message_success','Faq\'s details updated Successfully!');
        }

        $page_title = "Edit Faq";
        $faqsDetails = Faq::where(['id'=>$id])->first();        
        return view('admin.edit_faq')->with(compact('faqsDetails','page_title'));
    }

    public function deleteFaq($id = null){
        if(!empty($id)){
            Faq::where(['id'=>$id])->delete();
            return redirect()->back()->with('flash_message_success','Faq\'s deleted Successfully!');
        }
    }
}
