<?php

namespace App\Models\API;

use App\Http\Controllers\API\OpcionController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Opcion extends Model
{
    use HasFactory;

    protected $table = "opcion";

    protected $fillable = [
        "OPC_CODIGO",
        "SIS_CODIGO",
        "DESCRI"
    ];

    public function saveOption($request,$limit,$offset)
    {
        $codigo = $request->input('CODIGO');

        $sistema = $request->input('SISTEMA');

        $desc = $request->input('DESCRIPCION');

        $search = Opcion::where('OPC_CODIGO',$codigo)->get()->first();

        if ($search == null) {
            $object = [
                "OPC_CODIGO" => $codigo,
                "SIS_CODIGO" => $sistema,
                "DESCRI" => $desc
            ];

            Opcion::create($object);

            return ["options" => Opcion::limit($limit)->offset($offset)->get(), "total" => Opcion::all()->count()];
        }else{
            $object = [
                "SIS_CODIGO" => $sistema,
                "DESCRI" => $desc
            ];

            Opcion::where('OPC_CODIGO',$codigo)->update($object);

            return ["options" => Opcion::limit($limit)->offset($offset)->get(), "total" => Opcion::all()->count()];
        }

        return $search;
    }

    public function deleteOption($codigo,$limit,$offset)
    {
        Opcion::where('OPC_CODIGO',$codigo)->delete();

        return ["options" => Opcion::limit($limit)->offset($offset)->get(), "total" => Opcion::all()->count()];
    }

    public function getOptionsByProfile($profile){
        $res = DB::table('perfil')
        ->join('opcperfil','perfil.CODIGO','=','opcperfil.CODIGO')
        ->join('opcion','opcperfil.OPC_CODIGO','=','opcion.OPC_CODIGO')
        ->join('sistema','opcion.SIS_CODIGO','=','sistema.SIS_CODIGO')
        ->select('opcion.*','sistema.SIS_DESCRI',)
        ->where('perfil.CODIGO',$profile)
        ->get();

        $sistemas = DB::table('sistema')->get();

        return ["options"=>$res,"systems"=>$sistemas];
    }

    public function getAllOptions(){
        $res = DB::table('opcion')
        ->join('sistema','sistema.SIS_CODIGO','=','opcion.SIS_CODIGO')
        ->select('opcion.*','sistema.SIS_CODIGO','sistema.SIS_DESCRI')
        ->get();

        return ["allOptions"=>$res];
    }

    public function saveProfileOption($profile,$option)
    {
        $obj = [
            "CODIGO" => $profile,
            "OPC_CODIGO" => $option 
        ];

        return OpcionPerfil::create($obj);
    }

    public function deleteProfileOption($profile,$option)
    {
        return  OpcionPerfil::where("CODIGO",$profile)->where("OPC_CODIGO",$option)->delete();
    }
}
