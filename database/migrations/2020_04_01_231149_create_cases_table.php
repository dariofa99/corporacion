<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('case_number');

            $table->bigInteger('type_status_id')->unsigned();
            $table->foreign('type_status_id')->references('id')->on('references_table')
            ->onDelete('cascade')->onUpdate('cascade');
           

            $table->bigInteger('type_case_id')->unsigned();
            $table->foreign('type_case_id')->references('id')->on('references_table')
            ->onDelete('cascade')->onUpdate('cascade');
           
            $table->bigInteger('reception_id')->unsigned();
            $table->foreign('reception_id')->references('id')->on('receptions')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('type_branch_law_id')->unsigned();
            $table->foreign('type_branch_law_id')->references('id')->on('references_table')
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
        Schema::dropIfExists('cases');
    }
}
