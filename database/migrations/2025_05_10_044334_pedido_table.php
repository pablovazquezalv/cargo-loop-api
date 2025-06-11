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

            // 🔗 Relaciones
            $table->unsignedBigInteger('id_company'); // Empresa que recibe el pedido
            $table->unsignedBigInteger('id_repartidor')->nullable(); // Repartidor asignado
            $table->unsignedBigInteger('cliente_id')->nullable(); // Cliente que hace el pedido (opcional)

            // 📦 Datos del pedido
            $table->integer('cantidad')->default(1);
            $table->string('estado_pedido', 20)->default('pendiente'); // pendiente, en_proceso, entregado, cancelado, etc.
            $table->text('observaciones')->nullable(); // Observaciones generales del pedido

            // 🛍️ Producto o material
            $table->string('tipo_de_material'); // Tipo de carga o producto
            $table->decimal('peso'
            )->nullable(); // Peso en kg
            $table->string('dimensiones')->nullable(); // Ej: 40x40x20 cm
            $table->text('descripcion_carga')->nullable();
            $table->string('especificacion_carga')->nullable();
            $table->string('tipo_industria')->nullable();
            $table->string('requerimiento_carga')->nullable();

            // 🚗 Vehículo
            $table->string('tipo_de_vehiculo'); // Moto, coche, camión, etc.
            $table->string('tipo_unidad'); // Unidad específica

            // 💳 Pago
            $table->string('tipo_de_pago'); // Efectivo, tarjeta, etc.
            $table->decimal('valor_carga'); // Valor monetario de la carga
            $table->decimal('total')->nullable(); // Total general

            // 📍 Ubicación - Recoger
            $table->decimal('ubicacion_recoger_lat' );
            $table->decimal('ubicacion_recoger_long');
            $table->string('ubicacion_recoger_descripcion');

            // 🏠 Ubicación - Entregar
            $table->decimal('ubicacion_entregar_lat');
            $table->decimal('ubicacion_entregar_long');
            $table->string('ubicacion_entregar_direccion');

            // 👤 Contacto
            $table->string('nombre_contacto');

            // 📄 Archivos adjuntos
            $table->string('seguro_carga')->nullable(); // Archivo del seguro
            $table->string('cartaporte')->nullable(); // Archivo de cartaporte
            $table->boolean('aplica_seguro')->default(false);

            // ⏱️ Tiempos
            $table->date('fecha_carga'); // Fecha del inicio del pedido
            $table->timestamp('fecha_pedido')->nullable(); // Registro del pedido
            $table->timestamp('hora_entrega_estimada')->nullable();
            $table->timestamp('hora_entrega_real')->nullable();

            $table->timestamps();

            // 🔒 Foreign keys (opcional si tienes modelos)
             $table->foreign('id_company')->references('id')->on('companies');
             $table->foreign('id_repartidor')->references('id')->on('users');
             $table->foreign('cliente_id')->references('id')->on('clientes');

            // Relación con la tabla user_cliente
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
