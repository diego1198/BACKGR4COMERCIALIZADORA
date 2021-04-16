<?php

namespace App\Models\API;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioPerfil extends Model
{
    use HasFactory;

    protected $table = "usuarioperfil";

    protected $fillable=[
        "PER_CODIGO",
        "EMP_CODIGO",
        "CODIGO_USUARIO",
        "FECHASIGNA"
    ];

    public function getUsersAsigned()
    {
        return UsuarioPerfil::all();
    }

    public function add_profile_default($user)
    {
        $obj = [
            "PER_CODIGO"=>"Usuario",
            "EMP_CODIGO"=>$user["EMP_CODIGO"],
            "CODIGO_USUARIO"=>$user["CODIGO_USUARIO"],
            "FECHASIGNA"=>Carbon::now()
        ];

        UsuarioPerfil::create($obj);
    }

    public function assignProfile($request)
    {
        $obj = [
            "PER_CODIGO" => $request->input("PER_CODIGO"),
            "EMP_CODIGO" => $request->input("EMP_CODIGO"),
            "CODIGO_USUARIO" => $request->input("CODIGO_USUARIO"),
            "FECHASIGNA"=>Carbon::now()
        ];

        return UsuarioPerfil::create($obj);
    }

    public function desassignProfile($perfil,$codigo)
    {
        return UsuarioPerfil::where('PER_CODIGO',$perfil)->where('EMP_CODIGO',$codigo)->delete();
    }
}
