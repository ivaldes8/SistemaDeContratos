<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntidadServicioContratoESTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entidad_servicio_contrato_e_s', function (Blueprint $table) {
            $table->id();
            $table->string('idServicioS')->required();
            $table->string('idContratoEspecifico')->required();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entidad_servicio_contrato_e_s');
    }
}
