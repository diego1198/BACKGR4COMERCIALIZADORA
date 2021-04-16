<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\API\Perfil;
use App\Models\API\UsuarioPerfil;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
    public function get_profiles($limit, $offset)
    {
        $perfil = new Perfil();
        $res = $perfil->limit($limit)->offset($offset)->get();
        $total = $perfil->get()->count();

        return response([
            "profiles" => $res,
            "total" => $total
        ]);
    }

    public function get_all_profiles()
    {
        $perfil = new Perfil();
        $res = $perfil->all();

        $usuario_perfil = new UsuarioPerfil();

        return response([
            "profiles" => $res,
            "usuarioPerfil" => $usuario_perfil->getUsersAsigned()
        ]);
    }

    public function save_profiles(Request $request)
    {

        $profile = new Perfil();

        $res = $profile->savePerfil($request);

        return response($res);
    }

    public function delete_profile($id)
    {
        $profile = new Perfil();

        $res = $profile->deletePerfil($id);

        return response($res);
    }

    public function get_users_profile($perfil)
    {
        $profile = new Perfil();

        $res = $profile->getUsersProfile($perfil);

        return response(["users"=>$res]);
    }

    public function assign_profile(Request $request)
    {
        $usuario_perfil = new UsuarioPerfil();

        $res = $usuario_perfil->assignProfile($request);

        return response($res);
    }

    public function desassign_profile($perfil,$codigo){
        $usuario_perfil = new UsuarioPerfil();

        $res = $usuario_perfil->desassignProfile($perfil,$codigo);

        return response($res);
    }

    public function get_user_profile($email)
    {
        $perfil = new Perfil();

        $res = $perfil->getUserProfile($email);

        return response($res);
    }
}
