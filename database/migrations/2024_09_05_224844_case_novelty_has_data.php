<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CaseNoveltyHasData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_novelty_has_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('value')->nullable();  
            $table->string('value_is_other')->nullable();   
                          
            $table->bigInteger('reference_data_id')->unsigned();
            $table->foreign('reference_data_id')->references('id')->on('references_data')
            ->onDelete('cascade')->onUpdate('cascade');
         
            $table->bigInteger('reference_data_option_id')->unsigned();
            $table->foreign('reference_data_option_id')->references('id')->on('references_data_options')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('case_id')->unsigned();
            $table->foreign('case_id')->references('id')->on('cases')->onDelete('cascade')
            ->onUpdate('cascade');	
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
        Schema::dropIfExists('case_novelty_has_data');
    }
}
