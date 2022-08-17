<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntidadGrupoOrganismosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entidad_grupo_organismos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entidad_id')->unsigned()->nullable();
            $table->unsignedBigInteger('org_id')->unsigned()->nullable();
            $table->foreign('org_id')->references('id')->on('organismos')->nullOnDelete();
            $table->unsignedBigInteger('grupo_id')->unsigned()->nullable();
            $table->foreign('grupo_id')->references('id')->on('grupos')->nullOnDelete();
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
        Schema::dropIfExists('entidad_grupo_organismos');
    }
}
