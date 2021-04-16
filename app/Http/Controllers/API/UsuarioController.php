<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\PasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\API\Usuario;
use App\Models\API\Empleado;
use App\Models\API\UsuarioPerfil;
use Illuminate\Support\Facades\Mail;

class UsuarioController extends Controller
{
    public function get_users($limit, $offset)
    {
        $user = new Usuario();

        $users = $user->getAllUsers($limit,$offset);

        return response($users);
    }

    public function get_all_users()
    {
        $user = new Usuario();

        $users = $user->getAllUsers2();

        return response($users);
    }

    public function save_user(Request $request)
    {

        $empleado = new Empleado();

        $res = $empleado->saveEmpleado($request);

        $id = $request->input('CODIGO');

        $user = new Usuario();

        if($id == 'null'){
            $cod = DB::table('usuario')->max('CODIGO_USUARIO');
            $newId = $cod + 1;

            $password = uniqid('user_');

            $obj = [
                "EMP_CODIGO"=>$res,
                "CODIGO_USUARIO"=>$newId,
                "USU_PASWD"=>md5($password),
                "USU_PIEFIR"=>$request->input("EMP_NOMBRE").' '. $request->input('APELLIDO'),
                "ULTIMO_PASSWORD"=>"",
                "EMAIL"=>$request->input("EMP_EMAIL"),
                "EST_CODIGO"=>"A",
                "PASSWORD"=>$password
            ];

            $response = $user->saveUser($obj);

            /* $perfilUser = new UsuarioPerfil();

            $perfilUser->add_profile_default($response); */

            Mail::to($request->input("EMP_EMAIL"))->queue(new PasswordMail($obj));

        }else{
            $obj = [
                "EMP_CODIGO"=>$res,
                "USU_PIEFIR"=>$request->input("EMP_NOMBRE").' '. $request->input('APELLIDO'),
                "EMAIL"=>$request->input("EMP_EMAIL"),
            ];

            $response = $user->updateUser($obj);
        }

        return response()->json([
            "response" => $response
        ]);
    }

    public function get_user_by_email(Request $request)
    {
        $email = $request->input("email");
        $pass = $request->input("password");

        $user = new Usuario();

        $res = $user->getUserByEmail($email, $pass);


        return response($res);
    }

    public function get_user_by_id($id)
    {
        $user = new Usuario();
        
        $res = $user->getUserById($id);
        
        return response($res);
    }
    
    public function change_password(Request $request)
    {
        $user = new Usuario();
        
        $email = $request->input("EMAIL");
        $lastPass = $request->input("lastPassword");
        $newPass = $request->input("newPassword");

        $res = $user->changePassword($email,$lastPass,$newPass);

        return response([
            "msg"=>$res
        ]);

    }
}
