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
        Schema::create('owners_areas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('area_id');
            $table->foreign('area_id')->references('id')->on('parque_areas');
            $table->unsignedBigInteger('parque_id');
            $table->foreign('parque_id')->references('id')->on('parques');
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
        Schema::dropIfExists('owners_areas');
    }
};
