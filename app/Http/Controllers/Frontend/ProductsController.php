<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Certificate;
use App\Variety;
use App\Process;
use App\Category;
use App\Product;
use App\Cart;
use Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProductsController extends Controller
{
	public function index(){
		$data['products'] = Product::offset(0)->limit(3)->orderBy('id','DESC')->get(); //offset(0)->limit(3)->
        $data['count_products'] = Product::orderBy('id','DESC')->get()->count();
        $data['max'] = Product::orderBy('id','DESC')->max('price');
        $data['min'] = Product::orderBy('id','DESC')->min('price');                
        $data['categories'] = Category::orderBy('id','DESC')->get();
        $data['certificates'] = Certificate::get();
        $data['varieties'] = Variety::get();
        $data['processes'] = Process::get();
        $data['page_title'] = "Buy-Coffee | Kal-Coffee";
		$data['page'] = "products";
        return view('home/products', $data);
 	}

 	public function details($id = null){
 		$data['product'] = Product::find($id);

 		$data['page_title'] = "Coffee Details | Kal-Coffee";
		$data['page'] = "products";
                return view('home/product_details', $data);
 	}

        public function search(Request $request){
            $q = Product::query();
            
            if ($request->keyword){
                    $q->where('product_name','like',$request->keyword);
            }

            if ($request->country){
                 $q->where('region', $request->country);
            }

            if ($request->location){
                 $q->where('region','like',$request->location);
            }

            if ($request->range_1){
                 $q->where('price', '>=' , $request->range_1);
            }

            if ($request->range_2){
                 $q->where('price', '<=', $request->range_2);
            }

            if ($request->variety){
                 $q->where('variety_id', $request->variety);
            }

            if ($request->process){
                 $q->where('process_id', $request->process);
            }

            if ($request->certificate){
                 $q->whereIn('certificate_id', $request->certificate);
            }

            $data['products'] = $q->orderBy('id','DESC')->get();
            $data['count_products'] = $q->orderBy('id','DESC')->get()->count();
            $data['max'] = Product::orderBy('id','DESC')->max('price');
            $data['min'] = Product::orderBy('id','DESC')->min('price');                
            $data['categories'] = Category::orderBy('id','DESC')->get();
            $data['certificates'] = Certificate::get();
            $data['varieties'] = Variety::get();
            $data['processes'] = Process::get();
            $data['page_title'] = "Buy-Coffee | Kal-Coffee";
            $data['page'] = "products";
            return view('home/products', $data);
        }


        public function loadmore(Request $request){
            $offset = $request->val;

            //$language = $this->Common_model->get_language_name();
            //echo $this->load->view('loadmoremedia',$data, true);
            $data['products'] = Product::offset($offset)->limit(3)->orderBy('id','DESC')->get();
            return view('home/loadmore', $data);
        }

}
