<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Usuario extends Model
{
    use HasFactory;

    protected $fillable = [
        'EMP_CODIGO',
        'USU_PASSWD',
        'EMP_CODIGO',
        'CODIGO_USUARIO',
        'USU_PASWD',
        'USU_FECCRE',
        'USU_FECMOD',
        'USU_PIEFIR',
        'ULTIMO_PASSWORD',
        'EMAIL',
        'OBSERVACIONES',
        'EST_CODIGO',
    ];

    protected $table = 'usuario';

    public function getAllUsers()
    {
        return Usuario::all();
    }

    public function saveUser($user){
        $newUser = Usuario::create($user);

        if($newUser){
            return $newUser;
        }
    }


}
