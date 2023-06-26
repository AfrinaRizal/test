<?php

namespace App\Http\Controllers;

use App\Models\admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class adminController extends Controller
{
      //list all the product
      public function listAdmin (){

        $obj = admin::get(['admin_id','name', 'pfile']);

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




    public function upload(Request $request){

        // $file = $request->file('file');
        $file = $request->file('pfile');
        $name = $request->input('name'); 

        // $file = $request->file('pname');

        $file_type = $file->getClientOriginalExtension();
        // $file_name = $file->getClientOriginalName();
        $original_name = $file->getClientOriginalName();
        //
        $file_name = time().rand(100,999).'-'.$original_name;

        // $md5Name = md5_file($request->file('pfile')->getRealPath());
        // $guessExtension = $request->file('pfile')->guessExtension();
        // $file = $request->file('pfile')->storeAs('../upload/uploadfile', $md5Name.'.'.$guessExtension  ,'your_disk');

        if((strtolower($file_type) == "jpg") || (strtolower($file_type) == "jpeg") || (strtolower($file_type) == "png")){
            $destinationPath = '../upload/uploadfile' ;            
            if($file->move($destinationPath,$file_name)){
                //ok
            }
            else{
                $file_name = "";
            }

        }

        $data = [
            'name'=> $name,
            'pfile'=> $file_name,
        ];

        $obj = admin::create($data)->first();
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
     public function deleteAdmin(Request $request)    {
        $admin_id = $request->input('admin_id');

        $obj = admin::where('admin_id',$admin_id)->delete(); 
        
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


    public function updateAdmin(Request $request){

        $admin_id = $request->input('admin_id');
        $name = $request->input('name');
        // $file = $request->file('pfile');      


        if ($request->hasFile('pfile') && $request->file('pfile')->isValid()) {
           
            $destinationPath = '../upload/uploadfile'; 
            // File exists and is valid
            $file = $request->file('pfile');
            $file_type = $file->getClientOriginalExtension();
            $original_name = $file->getClientOriginalName();
            $file_name = time() . rand(100, 999) . '-' . $original_name;
            $file->move($destinationPath,$file_name);

            $data = [
                "admin_id" => $admin_id ,
                "name" => $name ,
                "pfile" => $file_name ,
           
    
            ];
    
        } 
        
        else {
            // File not uploaded or is invalid
            $data = [
                "admin_id" => $admin_id ,
                "name" => $name ,
                // "pfile" => $file_name ,
           
    
            ];
    
        }


       
        // $obj = product::create($data);

        $obj = admin::where('admin_id',$admin_id)->update($data);


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


       //show product based on id
       public function showAdmin ($admin_id){


        $obj =  admin::select();
        if($admin_id != "undefined" &&  $admin_id != null){ $obj = $obj -> where('admin_id',$admin_id); }
        $obj = $obj -> first(['admin_id',
        'name',
        'pfile',
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
}
