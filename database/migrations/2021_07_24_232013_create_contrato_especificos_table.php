<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratoEspecificosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contrato_especificos', function (Blueprint $table) {
            $table->id();
            $table->string('idCM')->required();
            $table->string('idArea')->required();
            $table->bigInteger('noContratoEspecifico')->required();
            $table->string('estado')->required();
            $table->string('fechaIni')->required();
            $table->string('fechaEnd')->nullable();
            $table->string('ejecutorName')->nullable();
            $table->string('clienteName')->nullable();
            $table->text('observaciones')->nullable();
            $table->float('monto')->nullable();
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
        Schema::dropIfExists('contrato_especificos');
    }
}
