<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaselogHasDiary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caselog_has_diary', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('caselog_id')->unsigned();
            $table->foreign('caselog_id')->references('id')->on('case_log')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('diary_id')->unsigned();
            $table->foreign('diary_id')->references('id')->on('diary')
            ->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('caselog_has_diary');
    }
}
