<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaseDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('section')->nullable();   
             $table->boolean('is_list')->default(0);       
            $table->longText('value')->nullable();
            
            $table->bigInteger('case_id')->unsigned();
            $table->foreign('case_id')->references('id')->on('cases')
            ->onDelete('cascade')->onUpdate('cascade');
           
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
            ->onDelete('cascade')->onUpdate('cascade');
           
            
            $table->bigInteger('type_data_id')->unsigned();
            $table->foreign('type_data_id')->references('id')->on('references_table') 
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
        Schema::dropIfExists('case_data');
    }
}
