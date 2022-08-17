<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCMSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_m_s', function (Blueprint $table) {
            $table->id();
            $table->string('noContrato')->required();
            $table->date('fechaFirma')->required();
            $table->date('fechaVenc')->required();
            $table->string('contacto')->required();
            $table->string('email')->required();
            $table->string('recibidoPor')->required();
            $table->string('observ')->required();
            $table->unsignedBigInteger('entidad_id')->unsigned()->nullable();
            $table->foreign('entidad_id')->references('id')->on('entidad_client_providers')->nullOnDelete();
            $table->unsignedBigInteger('tipo_id')->unsigned()->nullable();
            $table->foreign('tipo_id')->references('id')->on('tipo_c_m_s')->nullOnDelete();
            $table->unsignedBigInteger('estado_id')->unsigned()->nullable();
            $table->foreign('estado_id')->references('id')->on('estado_c_m_s')->nullOnDelete();
            $table->unsignedBigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
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
        Schema::dropIfExists('c_m_s');
    }
}
