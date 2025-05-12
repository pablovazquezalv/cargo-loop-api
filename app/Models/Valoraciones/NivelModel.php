<?php

namespace App\Models\Valoraciones;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NivelModel extends Model
{
     use HasFactory;

    protected $table = 'niveles';

    protected $fillable = [
        'nombre',
        'descripcion',
        'attempts',
        'reserved_at',
        'available_at',
    ];
}
