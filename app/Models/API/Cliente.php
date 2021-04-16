<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'cliente';

    protected $fillable = [
        "CEDULA_CLIENTE",
        "CODIGO_CLIENTE",
        "NOMBRE_CLIENTE",
        "APELLIDO_CLIENTE",
        "DIRECCION_CLIENTE",
        "TELEFONO_CLIENTE",
        "EMAIL_CLIENTE",
    ];

    public function saveCliente($cliente)
    {
        $newId = DB::table('cliente')->max('CODIGO_CLIENTE');
        if($newId != null){
            $newId++;
        }else{
            $newId = 1;
        }


        $obj = [
            "CODIGO_CLIENTE"=>$newId,
            "CEDULA_CLIENTE"=>$cliente->cedula,
            "NOMBRE_CLIENTE"=>$cliente->nombre,
            "APELLIDO_CLIENTE"=>$cliente->apellido,
            "DIRECCION_CLIENTE"=>$cliente->direccion,
            "TELEFONO_CLIENTE"=>$cliente->telefono,
            "EMAIL_CLIENTE"=>$cliente->email,
        ];

        Cliente::create($obj);

        return $newId;
    }
}
