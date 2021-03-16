<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\API\Usuario;

class UsuarioController extends Controller
{
    public function get_users()
    {
        $user = new Usuario();

        return response()->json([
            "users" => $user->getAllUsers()
        ]);
    }

    public function save_user(Request $request)
    {

        $obj = [
            'EMP_CODIGO'=>$request->input('user_att'),
            'USU_PASSWD'=>$request->input('user_att'),
            'EMP_CODIGO'=>$request->input('user_att'),
            'CODIGO_USUARIO'=>$request->input('user_att'),
            'USU_PASWD'=>$request->input('user_att'),
            'USU_FECCRE'=>$request->input('user_att'),
            'USU_FECMOD'=>$request->input('user_att'),
            'USU_PIEFIR'=>$request->input('user_att'),
            'ULTIMO_PASSWORD'=>$request->input('user_att'),
            'EMAIL'=>$request->input('user_att'),
            'OBSERVACIONES'=>$request->input('user_att'),
            'EST_CODIGO'=>$request->input('user_att'),
        ];

        $user = new Usuario();
        $res = $user->saveUser($obj);

        return response()->json([
            "response"=>$res
        ]);
    }
}
