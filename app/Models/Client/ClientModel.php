<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;

class ClientModel extends Model
{
    //
     protected $table = 'user_cliente';

    protected $fillable = [
        'nombre_de_la_empresa',
        'razon_social',
        'direccion',
        'rfc',
        'no_patronal',
        'Clave_Interbencaria_de_la_empresa',
        'Comprabante_Fiscal',
        'Representante_legal',
        'Foto_identificacion',
        'Nombre_Del_Contacto_de_la_empresa',
        'Telefono',
        'Email',
        'Puesto',
        'Comprobante_de_domicilio',
        'attempts',
        'reserved_at',
        'available_at',
        'code',
    ];
}
