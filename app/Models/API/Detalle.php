<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class Detalle extends Model
{
    use HasFactory;

    protected $table = "detalle_factura";

    protected $fillable = [
        "NUMERO_FACTURA",
        "id_producto",
        "cantidad_producto",
        "precio_producto",
        "total_producto",
    ];

    public function saveDetalle($productos,$cod_factura)
    {
        $prod = new Producto();
        $products = json_decode($productos);

        try {
            foreach ($products as $product) {
                $obj = [
                    "NUMERO_FACTURA"=>$cod_factura,
                    "id_producto"=>$product->id,
                    "cantidad_producto"=>$product->cantidad,
                    "precio_producto"=>$product->precio,
                    "total_producto"=>$product->total
                ];
    
                Detalle::create($obj);

                $prod->subStock($product->id,$product->cantidad);
            }

            return ["ok"=>true,"msg"=>"saved successfull"];
        } catch (QueryException $e) {
            return ["ok"=>false,"msg"=>$e->errorInfo];
        }
        
    }
}
