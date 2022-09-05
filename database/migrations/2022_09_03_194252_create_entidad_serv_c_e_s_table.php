<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntidadServCESTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entidad_serv_c_e_s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('serv_id')->unsigned()->nullable();
            $table->unsignedBigInteger('ce_id')->unsigned()->nullable();
            $table->foreign('ce_id')->references('id')->on('c_e_s')->onDelete('cascade');
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
        Schema::dropIfExists('entidad_serv_c_e_s');
    }
}
