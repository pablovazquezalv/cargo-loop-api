<?php

namespace App\Models\Licencia;

use App\Models\Dealer\Dealer;
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
        return $this->hasMany(Dealer::class, 'tipo_licencia_id');
    }
}
