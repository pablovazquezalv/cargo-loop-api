<?php

namespace App\Models\Trasportista;

use App\Models\EmpresaTrasportistaModel\EmpresaTransportista;
use Illuminate\Database\Eloquent\Model;
use App\Models\Licencia\TipoDeLicencia;
use App\Models\Otp\LoginOtpModel;
use App\Models\TipoDeLicencia as ModelsTipoDeLicencia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserTrasportista extends Model
{
     use HasFactory;
     protected $table = 'user_transportista';

    protected $fillable = [
        'nombre',
        'direccion',
        'nss',
        'foto_licencia',
        'comprobante_domicilio',
        'foto_identificacion',
        'rfc',
        'carta_de_no_antecedentes',
        'telefono',
        'email',
        'tipo_licencia_id',
        'attempts',
        'reserved_at',
        'available_at',
    ];
    public function tipoDeLicencia()
    {
        return $this->belongsTo(ModelsTipoDeLicencia::class, 'tipo_licencia_id');
    }

    public function loginOtps()
    {
        return $this->hasMany(LoginOtpModel::class, 'user_id');
    }

    public function empresaTransportistas()
    {
        return $this->hasMany(EmpresaTransportista::class, 'user_id');
    }
}
