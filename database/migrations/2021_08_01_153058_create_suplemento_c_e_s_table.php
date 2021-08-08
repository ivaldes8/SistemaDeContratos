<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuplementoCESTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suplemento_c_e_s', function (Blueprint $table) {
            $table->id();
            $table->string('idCESuplemto')->required();
            $table->string('noSupCE')->required();
            $table->string('fechaIniSup')->required();
            $table->string('fechaEndSup')->required();
            $table->string('ejecutorSup')->required();
            $table->string('observacionesSup')->nullable();
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
        Schema::dropIfExists('suplemento_c_e_s');
    }
}
