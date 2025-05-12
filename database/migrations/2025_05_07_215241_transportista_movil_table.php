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
        Schema::create('tipo_de_licencia', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->unsignedTinyInteger('attempts');
            $table->timestamp('reserved_at')->nullable();
            $table->timestamp('available_at');
            $table->timestamps();
        });
       
        Schema::create('user_transportista', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('direccion');
            $table->string('nss');
            $table->string('foto_licencia');
            $table->string('comprobante_domicilio');
            $table->string('foto_identificacion');
            $table->string('rfc');
            $table->string('carta_de_no_antecedentes');
            $table->string('telefono');
            $table->string('email');
            $table->unsignedBigInteger('tipo_licencia_id');
            $table->unsignedTinyInteger('attempts');
            $table->timestamp('reserved_at')->nullable();
            $table->timestamp('available_at');
            $table->timestamps();

            $table->foreign('tipo_licencia_id')
                  ->references('id')
                  ->on('tipo_de_licencia');
                  
        });

        

        Schema::create('niveles', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion');
            $table->unsignedTinyInteger('attempts');
            $table->timestamp('reserved_at')->nullable();
            $table->timestamp('available_at');
            $table->timestamps();
        });

        Schema::create('login_otps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('code', 4);
            $table->timestamp('expires_at');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('user_transportista');
        });

        Schema::create('empresa_transportista', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('empresa_id');
            $table->timestamp('expires_at');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('user_transportista');
        });

       
       
      

      
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      
    }
};
