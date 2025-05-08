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
        Schema::create('User_Trasposrtista', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre');
            $table->string('Direccion');
            $table->string('NSS');
            $table->string('Foto_Licencia');
            $table->string('Comprobante_Domicilio');
            $table->string('Foto_Identificacion');
            $table->string('RFC');
            $table->string('Carta_De_No_Antecedentes');
            $table->string('telefono');
            $table->string('email');
            $table->unsignedInteger('Tipo_Licencia_id');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
            $table->foreign('Tipo_Licencia_id')->references('id')->on('Tipo_de_Licencia');
        });

        Schema::create('Tipo_de_Licencia', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });
        Schema::create('Niveles', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre');
            $table->string('Descripcion');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('login_otps', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('code', 4);
            $table->dateTime('expires_at');
            $table->unsignedInteger('created_at');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('Empresa_Trasposrtista', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('Empresa_id');
            $table->dateTime('expires_at');
            $table->unsignedInteger('created_at');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('pedido_transportista', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('pedido_id');
            $table->unsignedInteger('transportista_id');
            $table->dateTime('asignado_en')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('estado_asignacion', 50); // ejemplo: 'asignado', 'en camino', 'completado', 'cancelado'
            // $table->foreign('pedido_id')->references('id')->on('pedidos'); // Descomentar cuando la tabla 'pedidos' exista
            // $table->foreign('transportista_id')->references('id')->on('transportistas'); // Descomentar cuando la tabla 'transportistas' exista
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
