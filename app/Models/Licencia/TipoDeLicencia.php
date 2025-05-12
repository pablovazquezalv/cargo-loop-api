<?php

namespace App\Models;

use App\Models\Trasportista\UserTrasportista;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDeLicencia extends Model
{
    use HasFactory;

    protected $table = 'tipo_de_licencia';

    protected $fillable = [
        'nombre',
        'attempts',
        'reserved_at',
        'available_at',
    ];

    public function userTransportistas()
    {
        return $this->hasMany(UserTrasportista::class, 'tipo_licencia_id');
    }
}
