<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         Schema::create('user_cliente', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_de_la_empresa');
            $table->string('razon_social');
            $table->string('direccion');
            $table->string('rfc');
            $table->string('no_patronal');
            $table->string('Clave_Interbencaria_de_la_empresa');
            $table->string('Comprabante_Fiscal');
            $table->string('Representante_legal');
            $table->string('Foto_identificacion');
            $table->string('Nombre_Del_Contacto_de_la_empresa');
            $table->string('Telefono');
            $table->Integer('code',4)->nullable();
            $table->string('Email');
            $table->string('Puesto');
            $table->string('Comprobante_de_domicilio');
            $table->unsignedTinyInteger('attempts');
            $table->timestamp('reserved_at')->nullable();
            $table->timestamp('available_at');
            $table->timestamps();
            
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
