<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Contact;
use App\Solution;

class ContactsController extends Controller{
	public function contact_us(){
		$data['page_title'] = "Contact Queries";
		$data['contacts'] = Contact::paginate(5);
		return view('admin.contact_us',$data);
	}

	public function requested_solution(){
		$data['page_title'] = "Requested Solutions";
		$data['solutions'] = Solution::paginate(5);
		return view('admin.requested_solutions',$data);
	}
}
