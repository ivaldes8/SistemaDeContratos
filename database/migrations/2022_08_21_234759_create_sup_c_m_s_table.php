<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupCMSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sup_c_m_s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cm_id')->unsigned()->nullable();
            $table->foreign('cm_id')->references('id')->on('c_m_s')->onDelete('cascade');
            $table->unsignedBigInteger('obj_sup_id')->unsigned()->nullable();
            $table->foreign('obj_sup_id')->references('id')->on('obj_sup_c_m_s')->nullOnDelete();
            $table->string('noSupCM')->required();
            $table->date('fechaIni')->required();
            $table->date('fechaEnd')->required();
            $table->string('ejecutor')->required();
            $table->text('observ')->required();
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
        Schema::dropIfExists('sup_c_m_s');
    }
}
