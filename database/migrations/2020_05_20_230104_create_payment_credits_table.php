<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_credits', function (Blueprint $table) {
            $table->bigIncrements('id');
                   
            $table->string('value')->nullable();              
            $table->date('limit_payment_date')->nullable();  
            $table->date('payment_date')->nullable(); 
            $table->date('description_pmethod')->nullable(); 

            $table->bigInteger('payment_id')->unsigned();
            $table->foreign('payment_id')->references('id')->on('payments')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('payment_method_id')->unsigned();
            $table->foreign('payment_method_id')->references('id')->on('references_table')
            ->onDelete('cascade')->onUpdate('cascade');
            

            $table->bigInteger('type_status_id')->unsigned();
            $table->foreign('type_status_id')->references('id')->on('references_table')
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
        Schema::dropIfExists('payment_credits');
    }
}
