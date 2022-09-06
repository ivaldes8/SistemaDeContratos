<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntidadSupObjCESTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entidad_sup_obj_c_e_s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sup_c_e_id')->unsigned()->nullable();
            $table->foreign('sup_c_e_id')->references('id')->on('sup_c_e_s')->onDelete('cascade');
            $table->unsignedBigInteger('obj_sup_c_e_id')->unsigned()->nullable();
            $table->foreign('obj_sup_c_e_id')->references('id')->on('obj_sup_c_e_s')->onDelete('cascade');
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
        Schema::dropIfExists('entidad_sup_obj_c_e_s');
    }
}
