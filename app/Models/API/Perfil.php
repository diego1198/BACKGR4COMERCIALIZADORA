<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Perfil extends Model
{
    use HasFactory;

    protected $fillable = [
        'CODIGO',
        'DESCRIPCION',
        'OBSERVACION'
    ];

    protected $table = 'perfil';

    public function getPerfiles()
    {
        return Perfil::all();
    }

    public function getPerfilById($cod)
    {
        return Perfil::where('CODIGO', $cod)->get();
    }

    public function getPerfilByUser($id)
    {
        $result = DB::table('usuarioperfil')->where('EMP_CODIGO', $id)->get()->first();

        $perfil = Perfil::where('CODIGO', $result->PER_CODIGO)->get()->first();

        return $perfil;
    }

    public function savePerfil($request)
    {
        $codigo = $request->input('codigo');

        $desc = $request->input('descripcion');

        $obs = $request->input('observacion');

        $search = Perfil::where('CODIGO', $codigo)->get()->first();

        if ($search == null) {
            $object = [
                "CODIGO" => $codigo,
                "DESCRIPCION" => $desc,
                "OBSERVACION" => $obs
            ];

            Perfil::create($object);

            return ["profiles" => Perfil::all(), "total" => Perfil::all()->count()];
        } else {
            $object = [
                "DESCRIPCION" => $desc,
                "OBSERVACION" => $obs
            ];

            Perfil::where('CODIGO', $codigo)->update($object);

            return ["profiles" => Perfil::all(), "total" => Perfil::all()->count()];
        }
    }

    public function deletePerfil($id)
    {
        Perfil::where('CODIGO', $id)->delete();

        return ["profiles" => Perfil::all(), "total" => Perfil::all()->count()];
    }

    public function getUsersProfile($profile)
    {
        $res = DB::table('perfil')
                ->join('usuarioperfil','perfil.CODIGO','=','usuarioperfil.PER_CODIGO')
                ->join('usuario', 'usuarioperfil.CODIGO_USUARIO','=','usuario.CODIGO_USUARIO')
                ->join('empleado', 'usuario.EMP_CODIGO','=','empleado.CODIGO')
                ->select('empleado.*')
                ->where('perfil.CODIGO',$profile)
                ->get();
                
        return $res;        
    }

    public function getUserProfile($email)
    {
        $res = DB::table('usuario')
        ->join('usuarioperfil','usuario.CODIGO_USUARIO','=','usuarioperfil.CODIGO_USUARIO')
        ->join('perfil','usuarioperfil.PER_CODIGO','=','perfil.CODIGO')
        ->select('perfil.*')
        ->where('usuario.EMAIL',$email)
        ->get();

        return $res;
    }
}
