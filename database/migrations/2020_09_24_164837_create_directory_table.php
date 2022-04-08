<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDirectoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directory', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('number_phone')->nullable();
            $table->string('address')->nullable();
            $table->string('town')->nullable();
            $table->boolean('is_trusted')->nullable();
            $table->string('origin')->default('movil');
            $table->bigInteger('type_status_id')->unsigned();
            $table->foreign('type_status_id')->references('id')->on('references_table') 
           ->onDelete('cascade')->onUpdate('cascade');
           $table->bigInteger('user_id')->unsigned();
           $table->foreign('user_id')->references('id')->on('users') 
          ->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });

        Schema::create('directory_has_addata', function (Blueprint $table) {
            $table->bigIncrements('id');          
            $table->bigInteger('directory_id')->unsigned();
            $table->foreign('directory_id')->references('id')->on('directory')
            ->onDelete('cascade')->onUpdate('cascade');       

            $table->bigInteger('data_id')->unsigned();
            $table->foreign('data_id')->references('id')->on('aditional_data')
            ->onDelete('cascade')->onUpdate('cascade');  

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
            ->onDelete('cascade')->onUpdate('cascade');   

            $table->bigInteger('type_data_id')->unsigned();
            $table->foreign('type_data_id')->references('id')->on('references_data') 
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
        Schema::dropIfExists('directory');
    }
}
