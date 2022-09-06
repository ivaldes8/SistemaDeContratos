<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupCESTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sup_c_e_s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ce_id')->unsigned()->nullable();
            $table->foreign('ce_id')->references('id')->on('c_e_s')->onDelete('cascade');
            $table->string('noSupCE')->required();
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
        Schema::dropIfExists('sup_c_e_s');
    }
}
