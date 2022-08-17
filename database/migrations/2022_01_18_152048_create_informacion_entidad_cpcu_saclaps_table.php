<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformacionEntidadCpcuSaclapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informacion_entidad_cpcu_saclaps', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->double('value')->nullable();
            $table->date('date')->nullable();
            $table->double('plan')->nullable();
            $table->string('year')->nullable();
            $table->unsignedBigInteger('unidad_id')->unsigned()->nullable();
            $table->foreign('unidad_id')->references('id')->on('unidads')->onDelete('cascade');
            $table->unsignedBigInteger('entidad_id')->unsigned()->nullable();
            $table->foreign('entidad_id')->references('id')->on('entidads')->onDelete('cascade');
            $table->unsignedBigInteger('indicador_id')->unsigned()->nullable();
            $table->foreign('indicador_id')->references('id')->on('indicadors')->onDelete('cascade');
            $table->unsignedBigInteger('cpcu_id')->unsigned()->nullable();
            $table->foreign('cpcu_id')->references('id')->on('cpcus')->onDelete('cascade');
            $table->unsignedBigInteger('saclap_id')->unsigned()->nullable();
            $table->foreign('saclap_id')->references('id')->on('saclaps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('indicador_entidad_plan_productos');
    }
}
