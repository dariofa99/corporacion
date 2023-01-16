<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAditionalDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aditional_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('value')->nullable();  
            $table->string('section')->nullable();   
            $table->boolean('is_list')->default(0);
            
                          
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
        Schema::dropIfExists('aditional_data');
    }
}
