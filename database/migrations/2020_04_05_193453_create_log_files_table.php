<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     /*    Schema::create('log_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('original_name')->nullable();  
            $table->string('encrypt_name')->nullable();  
            $table->string('path')->nullable();  
            $table->string('size')->nullable();         
            
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('case_log_id')->unsigned();
            $table->foreign('case_log_id')->references('id')->on('case_log')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        }); */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_files');
    }
}
