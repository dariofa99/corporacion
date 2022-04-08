<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('value')->nullable();  
            $table->longText('description')->nullable();
            $table->string('concept')->nullable();
            $table->boolean('shared')->default(0);  
            $table->integer('num_payments')->default(1);

           
            $table->bigInteger('case_id')->unsigned();
            $table->foreign('case_id')->references('id')->on('cases')
            ->onDelete('cascade')->onUpdate('cascade');
            
            $table->bigInteger('type_status_id')->unsigned();
            $table->foreign('type_status_id')->references('id')->on('references_table')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('type_category_id')->unsigned();
            $table->foreign('type_category_id')->references('id')->on('references_table')
            ->onDelete('cascade')->onUpdate('cascade');
           

            $table->bigInteger('type_payment_id')->unsigned();
            $table->foreign('type_payment_id')->references('id')->on('references_table')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('type_periodpay_id')->unsigned();
            $table->foreign('type_periodpay_id')->references('id')->on('references_table')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });

        Schema::create('payment_has_files', function (Blueprint $table) {
            $table->bigIncrements('id');
         

            $table->bigInteger('payment_id')->unsigned();
            $table->foreign('payment_id')->references('id')->on('payments')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('file_id')->unsigned();
            $table->foreign('file_id')->references('id')->on('files')
            ->onDelete('cascade')->onUpdate('cascade');
            

            $table->bigInteger('type_category_id')->unsigned();

            $table->foreign('type_category_id')->references('id')->on('references_table')
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
        Schema::dropIfExists('payments');
        Schema::dropIfExists('payment_has_files');
    }
}
