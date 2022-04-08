<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferencesDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('references_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('categories')->nullable();
            $table->string('section')->nullable();  
            $table->boolean('is_visible')->default(1);   
            $table->string('table');
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
        Schema::dropIfExists('references_data');
    }
}
