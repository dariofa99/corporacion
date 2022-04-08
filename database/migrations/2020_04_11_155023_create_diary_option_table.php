<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiaryOptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diary_option', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('diary_id')->unsigned();
            $table->foreign('diary_id')->references('id')->on('diary')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('type_fact_id')->unsigned();
            $table->foreign('type_fact_id')->references('id')->on('references_table')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->string('title_fact')->nullable();          
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('diary_option');
    }
}
