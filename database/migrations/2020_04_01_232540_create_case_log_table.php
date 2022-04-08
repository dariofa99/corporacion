<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaseLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_log', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('concept')->nullable();  
            $table->dateTime('notification_date')->nullable(); 
            $table->date('filing_date')->nullable();  
            $table->longText('description')->nullable();  
            $table->boolean('shared')->default(0);  
            $table->boolean('share_on_diary')->default(0);  

           
            $table->bigInteger('type_log_id')->unsigned();
            $table->foreign('type_log_id')->references('id')->on('references_table')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('type_category_id')->unsigned();
            $table->foreign('type_category_id')->references('id')->on('references_data')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('case_id')->unsigned();
            $table->foreign('case_id')->references('id')->on('cases')
            ->onDelete('cascade')->onUpdate('cascade');   
            
            $table->bigInteger('type_status_id')->unsigned();
            $table->foreign('type_status_id')->references('id')->on('references_table')
            ->onDelete('cascade')->onUpdate('cascade');
            
            $table->timestamps();
        });

        Schema::create('caselog_has_files', function (Blueprint $table) {
            $table->bigIncrements('id');
           
            $table->bigInteger('caselog_id')->unsigned();
            $table->foreign('caselog_id')->references('id')->on('case_log')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('file_id')->unsigned();
            $table->foreign('file_id')->references('id')->on('files')
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
        Schema::dropIfExists('case_log');
        Schema::dropIfExists('caselog_has_files');
    }
}
