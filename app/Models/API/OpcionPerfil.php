<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpcionPerfil extends Model
{
    use HasFactory;

    protected $table = 'opcperfil';

    protected $fillable = [
        "CODIGO",
        "OPC_CODIGO"
    ];
}
