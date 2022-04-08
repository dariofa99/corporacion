<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       /*  Schema::create('wallets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('value')->nullable();  
            $table->string('balance')->nullable();  

           
            $table->bigInteger('case_id')->unsigned();
            $table->foreign('case_id')->references('id')->on('cases')
            ->onDelete('cascade')->onUpdate('cascade');
            
            $table->bigInteger('type_log_id')->unsigned();
            $table->foreign('type_log_id')->references('id')->on('references_table')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('type_category_id')->unsigned();
            $table->foreign('type_category_id')->references('id')->on('references_table')
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
        Schema::dropIfExists('wallet');
    }
}
