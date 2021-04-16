<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;

class Producto extends Model
{
    use HasFactory;

    protected $table = "productos";

    protected $fillable = [
        "descripcion",
        "costo",
        "precio",
        "stock",
        "imagen"
    ];

    public function getProducts($limit, $offset)
    {
        $res = DB::table('productos')->select('productos.*')->limit($limit)->offset($offset)->get();
        $total = Producto::all()->count();
        return ["products" => $res, "total" => $total];
    }

    public function saveProduct($request, $limit, $offset)
    {
        $id = $request->input('id');

        if ($id == 'null') {
            $obj = [
                "descripcion" => $request->input('descripcion'),
                "costo" => $request->input('costo'),
                "precio" => $request->input('precio'),
                "stock" => $request->input('stock'),
                "imagen" => $request->input('imagen')
            ];

            Producto::create($obj);
        } else {
            $obj = [
                "descripcion" => $request->input('descripcion'),
                "costo" => $request->input('costo'),
                "precio" => $request->input('precio'),
                "stock" => $request->input('stock'),
                "imagen" => $request->input('imagen')
            ];
            Producto::where('id',$id)->update($obj);
        }

        $res = DB::table('productos')->select('productos.*')->limit($limit)->offset($offset)->get();
        $total = Producto::all()->count();
        return ["products" => $res, "total" => $total];
    }

    public function deleteProduct($id,$limit,$offset)
    {

        Producto::where("id",$id)->delete();

        $res = DB::table('productos')->select('productos.*')->limit($limit)->offset($offset)->get();
        $total = Producto::all()->count();
        return ["products" => $res, "total" => $total];
    }

    public function getProductByName($search)
    {
        $res = DB::table('productos')->where("descripcion","like","%".$search."%")->get();

        return ["products"=>$res,"total"=>$res->count()];
    }

    public function subStock($id,$cant)
    {
        $prod = Producto::where('id',$id)->decrement('stock',$cant);
    }
}
