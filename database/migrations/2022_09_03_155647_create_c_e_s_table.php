<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCESTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_e_s', function (Blueprint $table) {
            $table->id();
            $table->string('noCE')->required();
            $table->date('fechaFirma')->required();
            $table->date('fechaVenc')->nullable();
            $table->string('ejecutor')->nullable();
            $table->string('cliente')->nullable();
            $table->string('observ')->nullable();
            $table->float('monto')->nullable();
            $table->unsignedBigInteger('c_m_id')->unsigned()->nullable();
            $table->foreign('c_m_id')->references('id')->on('c_m_s')->nullOnDelete();
            $table->unsignedBigInteger('estado_c_e_id')->unsigned()->nullable();
            $table->foreign('estado_c_e_id')->references('id')->on('estado_c_e_s')->nullOnDelete();
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
        Schema::dropIfExists('c_e_s');
    }
}
