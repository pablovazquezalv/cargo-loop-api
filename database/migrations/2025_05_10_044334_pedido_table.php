<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_cliente_id'); // Relación con el cliente que realiza el pedido
            $table->date('fecha_carga'); // Fecha de carga
            $table->string('lugar_origen'); // Lugar de origen
            $table->string('lugar_destino'); // Lugar de destino
            $table->string('tipo_unidad'); // Tipo de unidad
            $table->string('tipo_carga'); // Tipo de carga
            $table->text('descripcion_carga')->nullable(); // Descripción de la carga
            $table->string('especificacion_carga')->nullable(); // Especificaciones de la carga
            $table->string('nombre_contacto'); // Nombre de la persona de contacto
            $table->decimal('valor_carga', 10, 2); // Valor de la carga
            $table->boolean('aplica_seguro')->default(false); // Si aplica seguro
            $table->text('observaciones')->nullable(); // Observaciones
            $table->string('tipo_industria')->nullable(); // Tipo de industria
            $table->string('requerimiento_carga')->nullable(); // Requerimiento de carga
            $table->string('seguro_carga')->nullable(); // Archivo del seguro de carga
            $table->string('cartaporte')->nullable(); // Archivo del cartaporte
            $table->timestamps();

            // Relación con la tabla user_cliente
            $table->foreign('user_cliente_id')->references('id')->on('user_cliente');
        });

          Schema::create('pedido_transportista', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pedido_id');
            $table->unsignedBigInteger('transportista_id');
            $table->timestamp('asignado_en')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('estado_asignacion', 50);
            $table->timestamps();

            // Relación con la tabla pedidos
            $table->foreign('pedido_id')->references('id')->on('pedidos');
            $table->foreign('transportista_id')->references('id')->on('user_transportista');
        });
          Schema::create('comprobante_pedido', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pedido_transportista_id');
            $table->string('fotos_de_mercancia');
            $table->string('foto_factura');
            $table->integer('cantidad');
            $table->timestamp('asignado_en')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();

            // Relación con la tabla pedido_transportista
            $table->foreign('pedido_transportista_id')->references('id')->on('pedido_transportista');
        });

        Schema::create('liberacion_pedidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pedido_id');
            $table->unsignedBigInteger('transportista_id');
            $table->string('motivo', 50);
            $table->text('justificacion')->nullable();
            $table->string('evidencia')->nullable();
            $table->timestamp('liberado_en')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('estado', 20)->default('pendiente');
            $table->timestamps();

            // Relación con la tabla pedidos
            $table->foreign('pedido_id')->references('id')->on('pedidos');
            $table->foreign('transportista_id')->references('id')->on('user_transportista');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
