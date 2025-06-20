<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carga extends Model
{
    protected $table = 'cargas';
    protected $fillable = [
        'fecha_carga', 'lugar_origen', 'lugar_destino', 'tipo_unidad', 'tipo_carga',
        'descripcion_carga', 'especificacion_carga', 'nombre_contacto', 'valor_carga',
        'aplica_seguro', 'observaciones', 'tipo_industria', 'requerimiento_carga',
        'seguro_carga', 'cartaporte'
    ];
    // public function transportistas() {
    //     return $this->belongsToMany(Transportista::class, 'carga_transportista', 'pedido_id', 'transportista_id')
    //         ->withPivot('asignado_en', 'estado_asignacion')->withTimestamps();
    // }
}