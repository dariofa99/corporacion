<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCaseInputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_case_inputs', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('reference_data_id')->unsigned();
            $table->foreign('reference_data_id')->references('id')->on('references_data')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('case_id')->unsigned();
            $table->foreign('case_id')->references('id')->on('cases') 
           ->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users') 
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
        Schema::dropIfExists('user_case_inputs');
    }
}
