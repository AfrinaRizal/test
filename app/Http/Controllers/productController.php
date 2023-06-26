<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;


class productController extends Controller
{

    
    //insert product
    public function createProduct(Request $request){
        $product_id = $request->input('product_id'); 
        $product_name = $request->input('product_name'); 
        $category = $request->input('category'); 
        $price = $request->input('price'); 
        $stock = $request->input('stock'); 

        $data = [
            'product_id'=> $product_id,
            'product_name'=> $product_name,
            'category'=> $category,
            'price'=> $price,
            'stock'=> $stock,
        ];

        $obj = product::create($data)->first();

        if ($obj){
            return response()->json([
                'success'=>true,
                'data'=> $obj
            ]);
        }
        
        else{
            return response()->json([
                'success'=>true,
                'message'=> 'false'
            ]);
        }

    }


    //update product
    public function updateProduct(Request $request){

        $product_id = $request->input('product_id');
        $product_name = $request->input('product_name');
        $category = $request->input('category');
        $price = $request->input('price');
        $stock = $request->input('stock');


        $data = [
            "product_id" => $product_id ,
            "product_name" => $product_name ,
            "category" => $category ,
            "price" => $price ,
            "stock" => $stock ,

        ];

        // $obj = product::create($data);

        $obj = product::where('product_id',$product_id)->update($data);


        if($obj)  {
            // $token = $this->getToken($created_by);
            return response()->json([
                'success'=>true,
                'message'=>'Show Success!',
                'data'=>$obj,
                // 'token'=>$token,
            ],200);
        }
        else{
            return response()->json([
                'success'=>false,
                'message'=>"No Data!",
                'data'=>''
            ]);
        }
    }


    //delete product
    public function deleteProduct(Request $request)    {
        $product_id = $request->input('product_id');

        $obj = product::where('product_id',$product_id)->delete(); 
        
        if ($obj)  {
            return response()->json([
                'success'=>true,
                'message'=>"Berjaya Padam!",
                'data' => ''
            ],200);
        }
        else{
            return response()->json([
                'success'=>false,
                'message'=>"Gagal Padam!",
                'data'=>''
            ],400);
        }
    }
    
    //list all the product
    public function list (){

        $obj = product::get(['product_id','product_name', 'category','price','stock']);

        if($obj)  {
            return response()->json([
                'success'=>true,
                'message'=>'Show Success!',
                'data'=>$obj
            ],200);
        }
        else{
            return response()->json([
                'success'=>false,
                'message'=>"No Data!",
                'data'=>''
            ]);
        }

    }

    //show product based on id
    public function showProduct ($product_id){

        // $product_id = $request -> input('product_id');
        
        // $obj = product::
        // where('product_id',$product_id)
        // ->first(['product_id', 
        // 'product_name',
        // 'category',
        // 'price',
        // 'stock',
        // ]);
        $obj =  product::select();
        if($product_id != "undefined" &&  $product_id != null){ $obj = $obj -> where('product_id',$product_id); }
        $obj = $obj -> first(['product_id',
        'product_name',
        'category',
        'price',
        'stock',
        ]) ;
        
        // $obj =  product::select();
        // if ( $product_id != "undefined" &&  $product_id != null){ $obj = $obj -> where ('product_id',  $product_id);}

        if($obj)  {
            return response()->json([
                'success'=>true,
                'message'=>'Show Success!',
                'data'=>$obj
            ],200);
        }
        else{
            return response()->json([
                'success'=>false,
                'message'=>"No Data!",
                'data'=>''
            ]);
        }

    }


    //kira jumlah product yang ada
    public function totalProduct(Request $request){

        // //FIX SEARCHING
        // $Negeri  = $request->input('Negeri');
        // $NamaDUN  = $request->input('NamaDUN');
        // $NamaParlimen  = $request->input('NamaParlimen');

        // $obj = product::select(DB::RAW('count(*) as total'),'stock');

        // if($Negeri != null){ $obj = $obj -> where('Negeri',$Negeri); }
        // if($NamaDUN != null){ $obj = $obj -> where('NamaDUN',$NamaDUN); }
        // if($NamaParlimen != null){ $obj = $obj -> where('NamaParlimen',$NamaParlimen); }

        // $obj = $obj -> groupBy('stock')->get();
        $obj = DB::table('product')->selectRaw('count(product_id) as cnt')->pluck('cnt');


        if ($obj)   {
            return response()->json([
                'success'=>'true',
                'message'=>'Show Success!',
                'data'=>$obj
            ],200);
        }
        else{
            return response()->json([
                'success'=>false,
                'message'=>"No Data!",
                'data'=>''
            ]);
        }
    }


    //kira total price semua product
    public function total(Request $request){

        $obj = DB::table('product')->selectRaw('sum(price) as cnt')->pluck('cnt');


        if ($obj)   {
            return response()->json([
                'success'=>'true',
                'message'=>'Show Success!',
                'data'=>$obj
            ],200);
        }
        else{
            return response()->json([
                'success'=>false,
                'message'=>"No Data!",
                'data'=>''
            ]);
        }
    }



    public function joinCategory(){

        $obj = product::join('category', 'category.category_id', '=', 'product.category_id')
                        ->get();

        if($obj)  {
            return response()->json([
                'success'=>'true',
                'message'=>'Show Success!',
                'data'=>$obj
            ],200);
        }
        else{
            return response()->json([
                'success'=>false,
                'message'=>"No Data!",
                'data'=>''
            ]);
        }
    }


}
