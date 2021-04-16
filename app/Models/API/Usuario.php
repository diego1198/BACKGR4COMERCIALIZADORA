<?php

namespace App\Models\API;

use App\Http\Controllers\API\UsuarioController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Usuario extends Model
{
    use HasFactory;

    protected $fillable = [
        'EMP_CODIGO',
        'USU_PASSWD',
        'EMP_CODIGO',
        'CODIGO_USUARIO',
        'USU_PASWD',
        'USU_PIEFIR',
        'ULTIMO_PASSWORD',
        'EMAIL',
        'EST_CODIGO',
    ];

    protected $table = 'usuario';

    public function getAllUsers($limit, $offset)
    {
        $res = DB::table('usuario')
            ->join('empleado', 'usuario.EMP_CODIGO', '=', 'empleado.CODIGO')
            ->select(
                'usuario.CODIGO_USUARIO',
                'usuario.EMP_CODIGO',
                'usuario.EMAIL',
                'usuario.EST_CODIGO',
                'empleado.EMP_NOMBRE',
                'empleado.APELLIDO',
                'empleado.EMP_CEDULA',
            )
            ->limit($limit)
            ->offset($offset)
            ->get();

        return ["users" => $res, "total" => $res->count()];
    }

    public function getAllUsers2()
    {
        $res = DB::table('usuario')
            ->join('empleado', 'usuario.EMP_CODIGO', '=', 'empleado.CODIGO')
            ->select(
                'usuario.CODIGO_USUARIO',
                'usuario.EMP_CODIGO',
                'usuario.EMAIL',
                'usuario.EST_CODIGO',
                'empleado.EMP_NOMBRE',
                'empleado.APELLIDO',
                'empleado.EMP_CEDULA',
            )
            ->get();

        return ["users" => $res];
    }

    public function saveUser($user)
    {
        $newUser = Usuario::create($user);

        if ($newUser) {
            return $newUser;
        }
    }

    public function updateUser($user)
    {
        $user = Usuario::where('EMP_CODIGO', $user["EMP_CODIGO"])->update($user);

        return $user;
    }

    public function getUserByEmail($email, $pass)
    {
        $user = Usuario::where("EMAIL", $email)->first();

        if ($user != null) {
            if (md5($pass) === $user["USU_PASWD"]) {
                $perfil = new Perfil();
                //$per = $perfil->getPerfilByUser($user->CODIGO_USUARIO);
                $empleado = new Empleado();
                $emp = $empleado->getEmpleadoByCod($user->EMP_CODIGO);
                return ["user" => $emp, "msg" => "Clave correcta", "ok" => true, "ultimoPass" => $user["ULTIMO_PASSWORD"]];
            } else {
                return ["msg" => "Clave incorrecta", "ok" => false];
            }
        } else {
            return ["msg" => "Usuario incorrecto", "ok" => false];
        }
    }

    public function getUserById($id)
    {
        $res = DB::table('usuario')
            ->join('empleado', 'usuario.EMP_CODIGO', '=', 'empleado.CODIGO')
            ->select('empleado.*', 'usuario.*')
            ->where('usuario.EMP_CODIGO', $id)
            ->get();

        return $res;
    }

    public function changePassword($email, $pass1, $pass2)
    {
        $user = Usuario::where("EMAIL", $email)->first();

        if ($user != null) {
            if ($user["USU_PASWD"] === md5($pass2)) {
                return "SAME PASSWORD";
            } else {
                if (md5($pass1) === $user["USU_PASWD"]) {

                    $obj = [
                        "USU_PASWD" => md5($pass2),
                        "ULTIMO_PASSWORD" => md5($pass1)
                    ];

                    Usuario::where("EMAIL", $email)->update($obj);

                    return "OK";
                } else {
                    return "NOT EQUALS";
                }
            }
        } else {
            return "NOT USER";
        }
    }
}
