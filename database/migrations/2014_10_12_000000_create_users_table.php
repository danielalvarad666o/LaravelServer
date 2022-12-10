<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 20);
            $table->string('apellidos', 30);
            $table->unsignedBigInteger('edad');
            $table->string('email')->unique();
            $table->string('contraseña');
            $table->string('telefono');
            $table->string('codigo');
            $table->string('username');
            $table->unsignedBigInteger('numero_tarjeta');
            $table->foreign('numero_tarjeta')->references('id')->on('tarjetas');
            $table->boolean('status')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
