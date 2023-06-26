<?php

namespace App\Http\Controllers;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\product;
use Illuminate\Support\Facades\DB;
use PDF;

// require '../api_pentadbir/vendor/autoload.php';

class uploadController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');

    public function upload(Request $request){

        // $file = $request->file('file');
        $file = $request->file('pfile');
        // $pname = $request->input('pname'); 

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
            'pfile'=> $file_name,
        ];

        $obj = products::create($data)->first();
        
        
    }


}
