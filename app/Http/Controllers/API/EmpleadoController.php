<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\API\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function get_employee($id)
    {
        $emp = new Empleado();

        $res = $emp->getEmpleadoByCod($id);

        return response($res);
    }
}
