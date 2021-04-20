<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Input
use Illuminate\Support\Facades\DB;
use Auth;
use Session;
use Image;
//use Input;
use App\Certificate;
use App\Variety;
use App\Process;
use App\Category;
use App\Product;
use App\CoffeeNote;

class ProductsController extends Controller
{
    public function addProduct(Request $request){
    	if($request->isMethod('post')){
    		$data = request()->validate([
                'category_id' => 'required',
                'process_id' => 'required',
                'variety_id' => 'required',
                'certificate_id' => 'required',                
                'product_name' => 'required',
                'price' => 'required',
                'image' => 'required'
            ]);

            $data = $request->all();
    		$product = new Product;
    		$product->category_id = $data['category_id'];
            $product->process_id = $data['process_id'];
            $product->variety_id = $data['variety_id'];
            $product->certificate_id = implode(',', $data['certificate_id']);
    		$product->product_name = $data['product_name'];
    		//$product->product_code = $data['product_code'];
    		//$product->harvest = $data['harvest'];
            $product->country = $data['country'];
            $product->region = $data['region'];
            $product->score = $data['score'];
            $product->cupping_notes = $data['cupping_notes'];
            $product->bag_size = $data['bag_size'];
            $product->altitude = $data['altitude'];
            $product->sample_size = $data['sample_size'];
            $product->description = (!empty($data['description'])) ? $data['description'] : "";
    		$product->price = $data['price'];
            $product->sample_price = (!empty($data['sample_price'])) ? $data['sample_price'] : "";
            $product->espresso_notes = ($data['espresso_notes'] !="") ? implode(',', $data['espresso_notes']) : "";
            $product->filtered_notes = ($data['filtered_notes'] !="") ? implode(',', $data['filtered_notes']) : "";

    		// Upload Image

            if($request->hasFile('image')){
                $image = $this->uploadImage($request->image);
                $product->image = $image;
            }
            if($request->hasFile('map')){
                $map = $this->uploadImage($request->map);
                $product->map = $map;
            }
            if($request->hasFile('header_image')){
                $header_image = $this->uploadImage($request->header_image);
                $product->header_image = $header_image;
            }


    		$product->save();
    		/*return redirect()->back()->with('flash_message_success','Product has been added successfully!');*/
            return redirect('admin/view-products')->with('flash_message_success','Product has been added successfully!');
    	}

    	$data['categories'] = Category::where(['parent_id'=>0])->get();
        $data['espresso_notes'] = CoffeeNote::where(['type'=>'Espresso'])->get();
        $data['filtered_notes'] = CoffeeNote::where(['type'=>'Filtered Coffee'])->get();
    	$data['certificates'] = Certificate::get();
        $data['varieties'] = Variety::get();
        $data['processes'] = Process::get();
        /*$categories_dropdown = "<option value='' selected disabled>Select</option>";
    	foreach($categories as $cat){
    		$categories_dropdown .= "<option value='".$cat->id."'>".$cat->name."</option>";
    		$sub_categories = Category::where(['parent_id'=>$cat->id])->get();
    		foreach ($sub_categories as $sub_cat) {
    			$categories_dropdown .= "<option value = '".$sub_cat->id."'>&nbsp;--&nbsp;".$sub_cat->name."</option>";
    		}
    	}*/
    	$data['page_title'] = "Add Products";
        return view('admin.add_products',$data);
    }

    public function viewProducts(){
        $data['products'] = DB::table('products')
                        ->select('products.*','categories.name','processes.process_name','varieties.variety_name','certificates.certificate_name')
                        ->join('categories', 'categories.id', '=', 'products.category_id')
                        ->join('varieties', 'varieties.id', '=', 'products.variety_id')
                        ->join('certificates', 'certificates.id', '=', 'products.certificate_id')
                        ->join('processes', 'processes.id', '=', 'products.process_id')
                        ->paginate(10);
        //$products = json_decode(json_encode($products));
        /*foreach($products as $key => $val){
            $category_name = Category::where(['id'=>$val->category_id])->first();
            $products[$key]->category_name = $category_name->name;
        }*/
        //echo "<pre>"; print_r($products); die;
        $data['page_title'] = "Products";
        return view('admin.view_products',$data);
    }

    public function editProduct(Request $request, $id = null){
        if($request->isMethod('post')){
            $data = request()->validate([
                'category_id' => 'required',
                'process_id' => 'required',
                'variety_id' => 'required',
                'certificate_id' => 'required',
                'product_name' => 'required',
                'price' => 'required'
            ]);

            $data = $request->all();
            $newArray = array(
                'country' => $data['country'],
                'region' => $data['region'],
                'score' => $data['score'],
                'cupping_notes' => $data['cupping_notes'],
                'category_id' => $data['category_id'],
                'product_name' => $data['product_name'],
                'bag_size' => $data['bag_size'],
                'altitude' => $data['altitude'],
                'sample_size' => $data['sample_size'],
                'description' => (!empty($data['description'])) ? $data['description'] : "",
                'price' => $data['price'],
                'sample_price' => (!empty($data['sample_price'])) ? $data['sample_price'] : "",
                'espresso_notes' => implode(',', $data['espresso_notes']),
                'filtered_notes' => implode(',', $data['filtered_notes']),
                'certificate_id' => implode(',', $data['certificate_id']) 
            );

            // Upload Image
            if($request->hasFile('image')){
                $image = $this->uploadImage($request->image);
                $newArray['image'] = $image;
            }
            if($request->hasFile('map')){
                $map = $this->uploadImage($request->map);
                $newArray['map'] = $map;
            }
            if($request->hasFile('header_image')){
                $header_image = $this->uploadImage($request->header_image);
                $newArray['header_image'] = $header_image;
            }

            Product::where(['id'=>$id])->update($newArray);
            return redirect('/admin/view-products')->with('flash_message_success','Product updated Successfully!');
        }

        $data['page_title'] = "Edit Products";
        $data['productDetails'] = Product::where(['id'=>$id])->first();        
        $data['categories'] = Category::where(['parent_id'=>0])->get();
        $data['espresso_notes'] = CoffeeNote::where(['type'=>'Espresso'])->get();
        $data['filtered_notes'] = CoffeeNote::where(['type'=>'Filtered Coffee'])->get();
        $data['certificates'] = Certificate::get();
        $data['varieties'] = Variety::get();
        $data['processes'] = Process::get();
        //$levels = Category::where(['parent_id'=>0])->get();
        return view('admin.edit_product',$data);
    }

    public function deleteProduct(Request $request, $id = null){
        if(!empty($id)){
            Product::where(['id'=>$id])->delete();
            return redirect()->back()->with('flash_message_success','Product deleted Successfully!');
        }
    }

    private function uploadImage($image){
        $image_tmp = $image; //Input::file('image');
        if($image_tmp->isValid()){
            $extension = $image_tmp->getClientOriginalExtension();
            $filename = rand(111,99999).'.'.$extension;
            $image_path = 'images/admin/products/'.$filename;
            Image::make($image_tmp)->save($image_path);
            return $filename;
        }
    }

     public function detailsShow($product_name){
        $data['page_title'] = "Product | Details";
        $data['page'] = "Product Details";

         $data['products'] = DB::table('products')
                        ->select('products.*','categories.name','processes.process_name','varieties.variety_name','certificates.certificate_name')
                        ->join('categories', 'categories.id', '=', 'products.category_id')
                        ->join('varieties', 'varieties.id', '=', 'products.variety_id')
                        ->join('certificates', 'certificates.id', '=', 'products.certificate_id')
                        ->join('processes', 'processes.id', '=', 'products.process_id')
                        ->where('product_name','=',$product_name)->paginate(5);
                        
    //     //$products = json_decode(json_encode($products));
    //     /*foreach($products as $key => $val){
    //         $category_name = Category::where(['id'=>$val->category_id])->first();
    //         $products[$key]->category_name = $category_name->name;
    //     }*/
    //     //echo "<pre>"; print_r($products); die;
    //     $data['page_title'] = "Products";
    //     return view('admin.view_products',$data);
    // }


    //         // $name=$product_name;
    //          //dd($product_name);
    //         $data['page_title'] = "Product | Details";
    //         $data['page'] = "Product Details";
    //         $data['pro'] = DB::table('products')->where('product_name','=',$product_name)->paginate(5);
    //        // dd($data);
            return view('/admin/view_product_details',$data);
            // ->with('flash_message_success','You Profile Secure!');
        
    }
}
