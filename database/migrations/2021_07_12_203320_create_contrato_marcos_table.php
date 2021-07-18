<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratoMarcosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contrato_marcos', function (Blueprint $table) {
            $table->id();
            $table->string('noContrato')->required();
            $table->string('objeto')->required();
            $table->string('organismo')->required();
            $table->string('grupo')->nullable();
            $table->string('idClient')->required();
            $table->string('estado')->required();
            $table->string('fechaIni')->required();
            $table->string('fechaEnd')->required();
            $table->string('nombreContacto')->required();
            $table->string('emailContacto')->required();
            $table->string('elaboradoPor')->required();
            $table->text('observaciones')->nullable();
            $table->string('idFile')->nullable();
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
        Schema::dropIfExists('contrato_marcos');
    }
}
