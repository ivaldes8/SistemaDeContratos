<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupCPSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sup_c_p_s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cp_id')->unsigned()->nullable();
            $table->foreign('cp_id')->references('id')->on('c_p_s')->onDelete('cascade');
            $table->unsignedBigInteger('obj_sup_id')->unsigned()->nullable();
            $table->foreign('obj_sup_id')->references('id')->on('obj_sup_c_p_s')->nullOnDelete();
            $table->string('noSupCP')->required();
            $table->date('fechaIni')->nullable();
            $table->date('fechaEnd')->nullable();
            $table->string('ejecutor')->required();
            $table->text('observ')->nullable();
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
        Schema::dropIfExists('sup_c_p_s');
    }
}
