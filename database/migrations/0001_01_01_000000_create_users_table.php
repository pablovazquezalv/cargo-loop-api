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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('profile_picture')->nullable();
            $table->integer('status')->default(0); // 0: Inactivo, 1: Activo
            $table->integer('independiente')->default(0); // 0: No, 1: Si
            $table->integer('incompany')->default(0); // 0: No, 1: Si
            $table->string('code')->nullable();
            $table->string('ubication')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
           // 0: Pendiente, 1: Aprobado, 2: Rechazado
            $table->unsignedBigInteger('rol_id');
            $table->foreign('rol_id')->references('id')->on('roles')->onDelete('cascade');

            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            


            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
           
            //Campos repartidor
            $table->string('nss')->nullable();
            $table->string('picture_license')->nullable();
            $table->string('proof_of_residence')->nullable();
            $table->string('photo_identification')->nullable();
            $table->string('rfc')->nullable();
            $table->string('letter_of_no_criminal_record')->nullable();
            //tipo de licencia
            $table->string('type_license')->nullable();

           
           
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index()->onDelete('cascade');;
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
