<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntidadAreaServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entidad_area_servicios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('area_id')->unsigned()->nullable();
            $table->unsignedBigInteger('servicio_id')->unsigned()->nullable();
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
        Schema::dropIfExists('entidad_area_servicios');
    }
}
