<?php

namespace App\Models\EmpresaTrasportistaModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Trasportista\UserTransportista;
use App\Models\Trasportista\UserTrasportista;

class EmpresaTransportista extends Model
{
    use HasFactory;

    protected $table = 'empresa_transportista';

    protected $fillable = [
        'user_id',
        'empresa_id',
        'expires_at',
    ];

    
}
