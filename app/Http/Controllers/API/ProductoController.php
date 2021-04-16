<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\API\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function get_products($limit,$offset)
    {
        $product = new Producto();

        $res = $product->getProducts($limit,$offset);

        return response($res);
    }

    public function save_product(Request $request,$limit,$offset)
    {
        $product = new Producto();

        $res = $product->saveProduct($request,$limit,$offset);

        return response($res);
    }

    public function delete_product($id,$limit,$offset)
    {
        $product = new Producto();

        $res = $product->deleteProduct($id,$limit,$offset);

        return response($res);
    }

    public function get_product_by_name($search)
    {
        $product = new Producto();

        $res = $product->getProductByName($search);

        return response($res);
    }
}
