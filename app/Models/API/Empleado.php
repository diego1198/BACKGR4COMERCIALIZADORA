<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Empleado extends Model
{
    use HasFactory;

    protected $fillable = [
        'CODIGO',
        'APELLIDO',
        'EMP_NOMBRE',
        'EMP_FECHA_NAC',
        'EMP_FECHA_ING',
        'EMP_FECHA_SAL',
        'EMP_DIREC',
        'EMP_TELEFO',
        'EMP_EMAIL',
        'EMP_CEDULA',
        'EMP_CARGAS',
        'EMP_DISCAPA',
        'sexo',
        'IMAGE',
    ];

    protected $table = 'empleado';

    public function getEmpleadoByCod($cod)
    {
        $result = Empleado::where('CODIGO',$cod)->get()->first();

        return $result;
    }

    public function saveEmpleado($request)
    {
        $id = $request->input('CODIGO');

        if($id == 'null'){

            $cod = DB::table('empleado')->max('CODIGO');
            $newId = $cod + 1;

            $obj = [
                "CODIGO"=>$newId,
                "APELLIDO"=>$request->input('APELLIDO'),
                "EMP_NOMBRE"=>$request->input('EMP_NOMBRE'),
                "EMP_FECHA_NAC"=>$request->input('EMP_FECHA_NAC'),
                "EMP_FECHA_ING"=>$request->input('EMP_FECHA_ING'),
                "EMP_DIREC"=>$request->input('EMP_DIREC'),
                "EMP_TELEFO"=>$request->input('EMP_TELEFO'),
                "EMP_EMAIL"=>$request->input('EMP_EMAIL'),
                "EMP_CEDULA"=>$request->input('EMP_CEDULA'),
                "EMP_CARGAS"=>$request->input('EMP_CARGAS'),
                "EMP_DISCAPA"=>$request->input('EMP_DISCAPA'),
                "sexo"=>$request->input('sexo'),
                "IMAGE"=>$request->input('image')
            ];

            Empleado::create($obj);

            return $newId;

        }else{
            $obj = [
                "APELLIDO"=>$request->input('APELLIDO'),
                "EMP_NOMBRE"=>$request->input('EMP_NOMBRE'),
                "EMP_FECHA_NAC"=>$request->input('EMP_FECHA_NAC'),
                "EMP_FECHA_ING"=>$request->input('EMP_FECHA_ING'),
                "EMP_DIREC"=>$request->input('EMP_DIREC'),
                "EMP_TELEFO"=>$request->input('EMP_TELEFO'),
                "EMP_EMAIL"=>$request->input('EMP_EMAIL'),
                "EMP_CEDULA"=>$request->input('EMP_CEDULA'),
                "EMP_CARGAS"=>$request->input('EMP_CARGAS'),
                "EMP_DISCAPA"=>$request->input('EMP_DISCAPA'),
                "sexo"=>$request->input('sexo'),
                "IMAGE"=>$request->input('image')
            ];

            Empleado::where('CODIGO',$id)->update($obj);
            return $id;
        }

    }
}
