<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\API\Opcion;
use App\Models\API\Sistema;

class OpcionController extends Controller
{
    public function get_options($limit, $offset)
    {
        $opcion = new Opcion();
        $res = $opcion->limit($limit)->offset($offset)->get();
        $total = $opcion->get()->count();

        $sistema = new Sistema();

        return response([
            "options" => $res,
            "total" => $total,
            "systems" => $sistema->all()
        ]);
    }

    public function save_option(Request $request, $limit, $offset)
    {
        $option = new Opcion();

        $res = $option->saveOption($request, $limit, $offset);

        return response($res);
    }

    public function delete_option($codigo, $limit, $offset)
    {
        $option = new Opcion();

        $res = $option->deleteOption($codigo, $limit, $offset);

        return response($res);
    }

    public function get_options_by_profile($profile)
    {
        $option = new Opcion();

        $res = $option->getOptionsByProfile($profile);

        return response($res);
    }

    public function get_all_options()
    {
        $option = new Opcion();

        $res = $option->getAllOptions();

        return response($res);
    }

    public function assign_option($profile,$optiona){
        $option = new Opcion();

        $res = $option->saveProfileOption($profile,$optiona);

        return response($res);
    }

    public function desassign_option($profile,$optiona){
        $option = new Opcion();

        $res = $option->deleteProfileOption($profile,$optiona);

        return response($res);

    }
}
