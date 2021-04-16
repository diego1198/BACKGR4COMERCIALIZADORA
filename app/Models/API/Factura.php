<?php

namespace App\Models\API;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Factura extends Model
{
    use HasFactory;

    protected $table = 'cabecera_factura';

    protected $fillable = [
        "NUMERO_FACTURA",
        "CODIGO_CLIENTE",
        "EMP_CODIGO",
        "SUBTOTAL_FACTURA",
        "IVA_FACTURA",
        "TOTAL_FACTURA",
    ];

    public function saveCabecera($cod_cliente, $emp_codigo, $subtotal, $iva, $total)
    {
        try {
            $newId = DB::table('cabecera_factura')->max('NUMERO_FACTURA');

            if ($newId != null) {
                $newId++;
            } else {
                $newId = 1;
            }

            $obj = [
                "NUMERO_FACTURA" => $newId,
                "CODIGO_CLIENTE" => $cod_cliente,
                "EMP_CODIGO" => $emp_codigo,
                "SUBTOTAL_FACTURA" => $subtotal,
                "IVA_FACTURA" => $iva,
                "TOTAL_FACTURA" => $total,
            ];

            Factura::create($obj);

            return ["id" => $newId, "ok" => true];
        } catch (QueryException $e) {
            return ["id" => $e->errorInfo, "ok" => false];
        }
    }

    public function getLastId()
    {
        $newId = DB::table('cabecera_factura')->max('NUMERO_FACTURA');

        return $newId;
    }

    public function getFacturas($limit,$offset)
    {
        $res = DB::table('cabecera_factura')
        ->join('cliente','cabecera_factura.CODIGO_CLIENTE','=','cliente.CODIGO_CLIENTE')
        ->join('empleado','cabecera_factura.EMP_CODIGO','=','empleado.CODIGO')
        ->select(
            'cabecera_factura.*',
            'cliente.CEDULA_CLIENTE',
            'cliente.NOMBRE_CLIENTE',
            'cliente.APELLIDO_CLIENTE',
            'empleado.APELLIDO',
            'empleado.EMP_NOMBRE',
        )->limit($limit)->offset($offset)->get();

        $total = DB::table('cabecera_factura')->get();
        return ["facturas"=>$res,"total"=>$total->count()];
    }

    public function getFactura($id)
    {
        $factura = DB::table('cabecera_factura')
        ->join('cliente','cabecera_factura.CODIGO_CLIENTE','=','cliente.CODIGO_CLIENTE')
        ->join('empleado','cabecera_factura.EMP_CODIGO','=','empleado.CODIGO')
        ->select(
            'cabecera_factura.*',
            'cliente.*',
            'empleado.APELLIDO',
            'empleado.EMP_NOMBRE',
        )->where("cabecera_factura.NUMERO_FACTURA",$id)->get()->first();

        $productos = DB::table('detalle_factura')
        ->join("productos","detalle_factura.id_producto","=","productos.id")
        ->select(
            "detalle_factura.*",
            "productos.*"
        )->where("detalle_factura.NUMERO_FACTURA",$id)->get();

        return ["factura"=>$factura,"productos"=>$productos];

    }
}
