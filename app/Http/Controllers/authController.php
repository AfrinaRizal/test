<?php

namespace App\Http\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\users;
use PDF;

class authController extends Controller
{    

    public function getToken($id)  {
        $salt = "RMY7nZ3+s8xpU1n0O*0o_EGfdoYtd|iU_AzhKCMoSu_xhh-e|~y8FOG*-xLZ";
        $token     = hash("sha256", Str::random(32).$salt);
        $obj = users::where('id',$id)->update([
            'token' => $token
        ]);

        $token = false;

        if($obj){
            $obj = users::where('id',$id)->first(['token']);
            $random = hash("sha256", Str::random(32)).'0L1v3';
            $token = $random.$obj->token;
        }

        return $token;
    }


    

    public function register(Request $request) {
        $password = $request->input('password');
        $salt = "RMY7nZ3+s8xpU1n0O*0o_EGfdoYtd|iU_AzhKCMoSu_xhh-e|~y8FOG*-xLZ";
        $enc_password     = hash("sha256", $password.$salt);
        // dd($enc_password);
        $name = $request->input('name');
        $email = $request->input('email');
        $icnum = $request->input('icnum');
        $address = $request->input('address');
        $contact = $request->input('contact');


        $register = users::create([
            'name' => $name,
            'email' => $email,
            'icnum' => $icnum,
            'address' => $address,
            'contact' => $contact,
        ]);

        if ($register)  {
            return response()->json([
                'success'=>'true',
                'message'=>'Pendaftaran Rekod Berjaya!',
                'data'=>$register
            ],201);
        }

        else    {
            return response()->json([
                'success'=>'false',
                'message'=>'Bad Request',
                'data'=>$register
            ],400);
        }
    }

    public function login(Request $request){
        $icnum = $request->input('icnum');
        $password = $request->input('password');
        
        $userS = users::where('icnum',$icnum)->first();
        if($userS){
            $salt = "RMY7nZ3+s8xpU1n0O*0o_EGfdoYtd|iU_AzhKCMoSu_xhh-e|~y8FOG*-xLZ";
            $enc_password  = hash("sha256", $password.$salt);
            // dd($enc_password);
            if($userS->password === $enc_password){
                $token = Str::random(32);
    
                $user = users::where('icnum',$icnum)->update([
                    'token' => $token
                ]);
    
                if($user){
                    $token = $this->getToken($userS->id);
                    return response()->json([
                        'success'=>true,
                        'token'=>$token,
                        'icnum' => $icnum,
                        'message'=>'Log Masuk Berjaya',
                        'data'=>$userS, // id_users, nama, icno, password, token
                    ],200);
                }
                else {
                    return response()->json([
                        'success'=>false,
                        'token'=>$token,
                        'message'=>'Log Masuk Gagal',
                        'data'=>'',
                    ],400);
                }
            }
            else{
                return response()->json([
                    'success'=>false,
                    // 'token'=>$token,
                    'message'=>'Log Masuk Gagal',
                    'data'=>'Wrong Combination. Please Try Again.',
                    'swal'=>'info',
                ],400);
            }
        }
        else {
            return response()->json([
                'success'=>false,
                // 'token'=>$token,
                'messages'=>'Log Masuk Gagal',
                'data'=>'Pengguna Tidak Aktif. Sila Hubungi Pentadbir Sistem Untuk Maklumat Lanjut. Terima Kasih.',
                'swal'=>'error',
            ],201);
        }
    }

    public function showGetResetpassword($resetpassword)  {

        $users = users::where('resetpassword',$resetpassword)->first();

        if ($users)   {
            return response()->json([
                'success'=>'true',
                'message'=>'Show Success!',
                'data'=>$users
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


    public function showIcEmel(Request $request)  {
        $icno = $request->input('icno');
        $passwords = $request->input('passwords');

        $users = users::where('icno',$icno)->where('passwords',$passwords)->first();

        if ($users)   {
            $mail = new PHPMailer(true);
            return response()->json([
                'success'=>'true',
                'message'=>'Show Success!',
                'data'=>$users
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

    public function resetpassword(Request $request)  {
        $icno = $request->input('icno');
        $password = $request->input('password');

        $users_search = users::where('icno',$icno)->first();
        $salt = "RMY7nZ3+s8xpU1n0O*0o_EGfdoYtd|iU_AzhKCMoSu_xhh-e|~y8FOG*-xLZ";
        $enc_password     = hash("sha256", $password.$salt);
        
        if ($users_search)  {
            $users = users::where('icno',$icno) -> update([
                'password' => $enc_password,
                'resetpassword' => null
            ]);
            if ($users)   {
                return response()->json([
                    'success'=>true,
                    'message'=>'Show Success!',
                    'data'=>''
                ],200);
            }
        } else  {
            return response()->json([
                'success'=>false,
                'message'=>"No Data!",
                'data'=>''
            ]);
        }
    }

    public function checkAuth(Request $request) {
        $icno = $request->input('icno');
        $token = explode('0L1v3', $request->input('token'));

        $users = users::where('icno',$icno)->where('token', $token[1])->first();

        if ($users)   {
            return response()->json([
                'success'=>'true',
                'message'=>'Show Success!',
                'data'=>$users
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

    public function show(Request $request)  {
        $icno = $request->input('icno');

        $users = users::where('icno',$icno)->first();

        if ($users)   {
            return response()->json([
                'success'=>'true',
                'message'=>'Show Success!',
                'data'=>$users
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


    public function uploadFile(Request $request){
        $file = $request->file('file');

        $file_type = $file->getClientOriginalExtension();
        $file_name = $file->getClientOriginalName();

        if((strtolower($file_type) == "jpg") || (strtolower($file_type) == "jpeg") || (strtolower($file_type) == "png")){
            $destinationPath = 'uploads_img' ;            
            if($file->move($destinationPath,$file_name)){
                //ok
            }
            else{
                $file_name = "";
            }

        }
        
        if ($file_name != "")  {
            return response()->json([
                'success'=>'true',
                'message'=>'Upload Success!',
                'location'=>'http://localhost/olive_ems/api_olive_ems/public/stat_negeri/'.$file_name
            ],201);
        }
        else{
            return response()->json([
                'success'=>false,
                'message'=>"Upload Fail!",
                'data'=>''
            ],401);
        }
    }

    
}
