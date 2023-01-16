<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLibraryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('library', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_file',120);
            $table->longText('description')->nullable();
            $table->string('route_file',120);
            $table->string('size', 20)->nullable(); 
            $table->integer('download')->nullable()->default(0);
            $table->date('limit_date')->nullable();

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('type_branch_law_id')->unsigned();
            $table->foreign('type_branch_law_id')->references('id')->on('references_table')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('references_table')
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
        Schema::dropIfExists('library');
    }
}
