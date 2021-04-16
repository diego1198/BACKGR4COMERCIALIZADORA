<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\API\Cliente;
use App\Models\API\Detalle;
use App\Models\API\Factura;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    public function new_factura(Request $request)
    {
        $cliente = $request->input('client');
        $productos = $request->input('products');

        $emp = $request->input('empleado');

        $subtotal = $request->input('subtotal');
        $iva = $request->input('iva');
        $total = $request->input('total');


        $client = new Cliente();

        $cod_cliente = $client->saveCliente(json_decode($cliente));

        $fact = new Factura();

        $cod_fact = $fact->saveCabecera($cod_cliente, $emp, $subtotal, $iva, $total);

        if ($cod_fact['ok']) {

            $detalle = new Detalle();

            $res = $detalle->saveDetalle($productos, $cod_fact["id"]);

            return response($res);
        } else {
            return response($cod_fact);
        }
    }

    public function last_id_factura()
    {
        $fact = new Factura();
        $id = $fact->getLastId();

        return response($id);
    }

    public function get_facturas($limit,$offset)
    {
        $fact = new Factura();
        $resp = $fact->getFacturas($limit,$offset);

        return response($resp);
    }

    public function get_factura($id)
    {
        $fact = new Factura();
        $resp = $fact->getFactura($id);

        return response($resp);
    }
}
