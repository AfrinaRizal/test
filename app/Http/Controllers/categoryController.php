<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class categoryController extends Controller
{
    //insert category
    public function createCategory(Request $request){
        //$category_id = $request->input('category_id'); 
        $name = $request->input('name'); 
        

        $data = [
            //'category_id'=> $category_id,
            'name'=> $name,
            
        ];

        $obj = category::create($data)->first();

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

    //list all the category
    public function listCategory (){

        $obj = category::get(['category_id','name',]);

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

    //update category
    public function updateCategory(Request $request){

        $category_id = $request->input('category_id');
        $name = $request->input('name');
        

        $data = [
            "category_id" => $category_id ,
            "name" => $name ,
        ];

        // $obj = category::create($data);
        $obj = category::where('category_id',$category_id)->update($data);


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


    //delete category
    public function deleteCategory(Request $request)    {
        $category_id = $request->input('category_id');

        $obj = category::where('category_id',$category_id)->delete(); 
        
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


    //show category by id 
    public function showCategory ($category_id){

        // $category_id = $request -> input('category_id');
        
        // $obj = category::
        // where('category_id',$category_id)
        // ->first(['category_id', 
        // 'name',
       
        // ]);
        $obj =  category::select();
        if ( $category_id != "undefined" &&  $category_id != null){ $obj = $obj -> where ('category_id',  $category_id); }
        $obj = $obj -> first(['category_id',
            'name',
            ]) ;

        // $obj = $obj -> get();

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

    
}
