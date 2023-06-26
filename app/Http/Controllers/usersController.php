<?php

namespace App\Http\Controllers;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\users;


// require '../api_pentadbir/vendor/autoload.php';

class usersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

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
        $password     = hash("sha256", $password.$salt);
        $name = strtoupper($request->input('name'));
        $email = $request->input('email');
        $icnum = $request->input('icnum');
        $address = $request->input('address');
        $contact = $request->input('contact');
        $created_by = $request->input('created_by');
        $updated_by = $request->input('updated_by');


        $obj = users::where('icnum',$icnum)->first();

        if ($obj)   {
            return response()->json([
                'success'=>false,
                'message'=>"User Already Registered.",
                'data'=>''
            ]);
        }
        else{
            $obj = users::create([
                'name' => $name,
                'email' => $email,
                'icnum' => $icnum,
                'address' => $address,
                'contact' => $contact,
                'password' => $password,
                'created_by' => $created_by,
                'updated_by' => $updated_by,
            ]);
    
            if ($obj)  {
                $token = $this->getToken($created_by);
                return response()->json([
                    'success'=>true,
                    'message'=>'Pendaftaran Rekod Berjaya!',
                    'data'=>$obj,
                    'token'=>$token
                ],201);
            }
    
            else    {
                return response()->json([
                    'success'=>false,
                    'message'=>'Bad Request',
                    'data'=>$obj
                ],400);
            }
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
    
    public function update(Request $request) {
        $id = $request->input('id');
        $name = strtoupper($request->input('name'));
        $email = $request->input('email');
        $icnum = $request->input('icnum');
        $address = $request->input('address');
        $contact = $request->input('contact');
        $updated_by = $request->input('updated_by');
        
        $obj = users::where('id', $id);

        $obj -> update([
                'name' => $name,
                'email' => $email,
                'icnum' => $icnum,
                'address' => $address,
                'contact' => $contact,
                'updated_by' => $updated_by,
        ]);

        if ($obj)  {
            $token = $this->getToken($updated_by);
            return response()->json([
                'success'=>'true',
                'message'=>'Kemaskini Rekod Berjaya!',
                'data'=>$obj,
                'token'=>$token
            ],201);
        }

        else    {
            return response()->json([
                'success'=>'false',
                'message'=>'Bad Request',
                'data'=>$obj
            ],400);
        }
    }

    public function checkpassword(Request $request)  {
        $icnum = $request->input('icnum');
        $password = $request->input('password');

        $salt = "RMY7nZ3+s8xpU1n0O*0o_EGfdoYtd|iU_AzhKCMoSu_xhh-e|~y8FOG*-xLZ";
        $enc_katalaluan     = hash("sha256", $password.$salt);
        $users_search = users::where('icnum',$icnum)->where('password',$enc_katalaluan)->first();
        
        if ($users_search)   {
            return response()->json([
                'success'=>true,
                'message'=>'Show Success!',
                'data'=>''
            ],200);
        } else  {
            return response()->json([
                'success'=>false,
                'message'=>"No Data!",
                'data'=>''
            ]);
        }
    }

    public function resetpassword(Request $request)  {
        $icnum = $request->input('icnum');
        $updated_by = $request->input('updated_by');
        $salt = "RMY7nZ3+s8xpU1n0O*0o_EGfdoYtd|iU_AzhKCMoSu_xhh-e|~y8FOG*-xLZ";
        $enc_katalaluan     = hash("sha256", $icnum.$salt);
        $obj = users::where('icnum',$icnum);
        
        $obj -> update([
            'password' => $enc_katalaluan,
            'updated_by' => $updated_by,
        ]);

        if ($obj)   {
            return response()->json([
                'success'=>true,
                'message'=>'Success Reset!',
                'data'=>'',
            ],200);
        } else {
            return response()->json([
                'success'=>false,
                'message'=>"Failed Reset!",
                'data'=>''
            ]);
        }
    }

    public function updatepassword(Request $request)  {
        $icnum = $request->input('icnum');
        $password = $request->input('password');
        $salt = "RMY7nZ3+s8xpU1n0O*0o_EGfdoYtd|iU_AzhKCMoSu_xhh-e|~y8FOG*-xLZ";
        $enc_katalaluan     = hash("sha256", $password.$salt);
        $obj = users::where('icnum',$icnum);
        
        $obj -> update([
            'password' => $enc_katalaluan
        ]);

        if ($obj)   {
            return response()->json([
                'success'=>true,
                'message'=>'Success Reset!',
                'data'=>''
            ],200);
        } else {
            return response()->json([
                'success'=>false,
                'message'=>"Failed Reset!",
                'data'=>''
            ]);
        }
    }

    public function show($icnum)  {
        // $icno = $request->input('id');

        $obj = users::where('icnum',$icnum)->first();

        if ($obj)   {
            return response()->json([
                'success'=>"true",
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

    public function showGetId($id)  {

        $users = users::where('id',$id)->first();

        if ($users)   {
            return response()->json([
                'success'=>true,
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

    // public function showGetIc($icno)  {
    //     $users = users::where('icno',$icno)->
    //                     where('users.statusrekod','01')->
                           
    //                             first();

    //     if ($users)   {
    //         $token = $this->getToken($users->id_users);
    //         return response()->json([
    //             'success'=>true,
    //             'message'=>'Show Success!',
    //             'data'=>$users,
    //             'token'=>$token
    //         ],200);
    //     }
    //     else{
    //         return response()->json([
    //             'success'=>false,
    //             'message'=>"No Data!",
    //             'data'=>''
    //         ],400);
    //     }
    // }

    public function list()  {
        $users = users::get();

        if ($users)   {
            return response()->json([
                'success'=>'true',
                'message'=>'List Success!',
                'data'=>$users
            ],200);
        }
        
    }

    // public function list_kod_kat_admin($kod_kat_admin)  {

    //     $users = users::where('adm_'.$kod_kat_admin, '!=', '99')->get();

    //     if ($users)   {
    //         return response()->json([
    //             'success'=>'true',
    //             'message'=>'List Success!',
    //             'data'=>$users
    //         ],200);
    //     }
        
    // }

    // public function listAll()  {
    //     $users = users::select('*','users.statusrekod AS statusrekod_users')->
    //                             join('pen_jenispengguna', 'pen_jenispengguna.id_jenispengguna', '=', 'users.FK_jenis_pengguna') -> 
    //                             leftjoin('pen_gelaran', 'pen_gelaran.id_gelaran', '=', 'users.barong_agent') -> 
    //                             leftjoin('pen_agensi', 'pen_agensi.id_agensi', '=', 'users.superadmin') -> 
    //                             orderby('users.name', 'ASC') ->
    //                             get();

    //     if ($users)   {
    //         return response()->json([
    //             'success'=>'true',
    //             'message'=>'List Success!',
    //             'data'=>$users
    //         ],200);
    //     }
        
    // }

    // public function listByCapaian(Request $request){

    //     $kod_kat_permohonan = $request->input('kod_kat_permohonan');
    //     $icno = $request->input('icno');

    //     // dd($kod_kat_permohonan);
    //     $obj = users::
    //     // orWhere('adm_pendaftaran','like','%'.$kod_kat_permohonan.'%')->
    //     // orWhere('adm_perakuan1','like','%'.$kod_kat_permohonan.'%')->
    //     // orWhere('adm_perakuan2','like','%'.$kod_kat_permohonan.'%')->
    //     // orWhere('adm_perakuan3','like','%'.$kod_kat_permohonan.'%')->
    //     // orWhere('adm_perakuan4','like','%'.$kod_kat_permohonan.'%')->
    //     // orWhere('adm_kelulusan','like','%'.$kod_kat_permohonan.'%')->
    //     where('icno','!=',$icno)->
    //     where('statusrekod','01')->
    //     get();

    //     // dd($obj);

    //     if($obj){
    //         return response()->json([
    //             'success'=>true,
    //             'message'=>"Senarai Berjaya!",
    //             'data' => $obj
    //         ],200);
    //     }
    //     else{
    //         return response()->json([
    //             'success'=>false,
    //             'message'=>"Senarai Gagal!",
    //             'data'=>''
    //         ],200);
    //     }
    // }

    // public function listByCapaianPegawai(Request $request){

    //     $kod_kat_permohonan = $request->input('kod_kat_permohonan');
    //     $noic = $request->input('noic');

    //     // dd($kod_kat_permohonan);
    //     $obj = users::
    //     // whereNot('noic',$noic)->
    //     orWhere('adm_pendaftaran','like','%'.$kod_kat_permohonan.'%')->
    //     orWhere('adm_perakuan1','like','%'.$kod_kat_permohonan.'%')->
    //     orWhere('adm_perakuan2','like','%'.$kod_kat_permohonan.'%')->
    //     orWhere('adm_perakuan3','like','%'.$kod_kat_permohonan.'%')->
    //     orWhere('adm_perakuan4','like','%'.$kod_kat_permohonan.'%')->
    //     orWhere('adm_kelulusan','like','%'.$kod_kat_permohonan.'%')->
    //     where('statusrekod','01')->
    //     get();

    //     // dd($obj);

    //     if($obj){
    //         return response()->json([
    //             'success'=>true,
    //             'message'=>"Senarai Berjaya!",
    //             'data' => $obj
    //         ],200);
    //     }
    //     else{
    //         return response()->json([
    //             'success'=>false,
    //             'message'=>"Senarai Gagal!",
    //             'data'=>''
    //         ],200);
    //     }
    // }

    public function editprofile(Request $request)    {
        $id = $request->input('id');
        $email = $request->input('email');
        $agensi = $request->input('agensi');
        $notel = $request->input('notel');
        $updated_by = $request->input('updated_by');

        $users = users::where('id_users', $id) -> update([
            'email' => $email,
            'agensi' => $agensi,
            'notel' => $notel,
            'updated_by' => $updated_by
        ]);

        if ($users)  {
            return response()->json([
                'success'=>true,
                'message'=>"Kemaskini Berjaya!",
                'data' => ''
            ],200);
        }
        else{
            return response()->json([
                'success'=>false,
                'message'=>"Kemaskini Gagal!",
                'data'=>''
            ],200);
        }
    }

    public function delete(Request $request)    {
        $id = $request->input('id_users');
        $updated_by = $request->input('updated_by');

        $users_search = users::where('id_users',$id)->first(); 
        switch($users_search->statusrekod)    {
            case "00": $users = users::where('id_users',$id) -> update([
                        'statusrekod' => '01',
                        'updated_by' => $updated_by,
                    ]);
                    break;
            case "01": $users = users::where('id_users',$id) -> update([
                        'statusrekod' => '00',
                        'updated_by' => $updated_by,
                    ]);
                    break;
        }
        $users_search = users::where('id_users',$id)->first(); 
        
        if ($users)  {
            // $token = $this->getToken($updated_by);
            return response()->json([
                'success'=>true,
                'message'=>"Berjaya Padam!",
                'data' => $users_search,
                // 'token' => $token
            ],200);
        }
        else{
            return response()->json([
                'success'=>false,
                'message'=>"Gagal Padam!",
                'data'=>''
            ],404);
        }
    }

    public function listByKatPermohonan(Request $request){
        $kod = $request->input('kod_kat_permohonan');
        $icno = $request->input('icno');

        $obj=users::
        orWhere('adm_pendaftaran','LIKE','%'.$kod.'%')->
        orWhere('adm_perakuan1','LIKE','%'.$kod.'%')->
        orWhere('adm_perakuan2','LIKE','%'.$kod.'%')->
        orWhere('adm_perakuan3','LIKE','%'.$kod.'%')->
        orWhere('adm_perakuan4','LIKE','%'.$kod.'%')->
        orWhere('adm_kelulusan','LIKE','%'.$kod.'%')->
        whereNot('icno',$icno)->
        get(
            [
            'adm_pendaftaran',
            'adm_perakuan1',
            'adm_perakuan2',
            'adm_perakuan3',
            'adm_perakuan4',
            'adm_kelulusan'
        ]
    );

    // dd($obj);

        if ($obj)  {
            return response()->json([
                'success'=>true,
                'message'=>"Kemaskini Berjaya!",
                'data' => ''
            ],200);
        }
        else{
            return response()->json([
                'success'=>false,
                'message'=>"Kemaskini Gagal!",
                'data'=>''
            ],200);
        }
    }

    function sendmail($to, $nameto, $subject, $message, $altmess) {
        echo $subject;
        $from = 'muhammadamri@protigatech.com';
        $namefrom = 'Amri';
        $mail = new PHPMailer();
        $mail->SMTPDebug = 0;
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = "mail.protigatech.com";
        $mail->Port = 465;
        $mail->Username = $from;
        $mail->Password = 'Amewii-0123';
        $mail->SMTPSecure = "ssl";
        $mail->setFrom($from, $namefrom);
        $mail->addCC($from, $namefrom);
        $mail->Subject = $subject;
        $mail->isHTML();
        $mail->Body = $message;
        $mail->AltBody = $altmess;
        $mail->addAddress($to, $nameto);
        return $mail->send();
    }
    

    public function logout(Request $request){

        // $users->logout();
        $icnum = $request->input('icnum');

        $user = users::where('icnum',$icnum)->logout();

    
        // Optionally, you can flash a message to the session indicating successful logout
        session()->flash('message', 'You have been logged out successfully.');
        
        // Redirect the user to a relevant page, such as the login page
        return redirect()->route('index.html');
    }
  
}
