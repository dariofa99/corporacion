<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePanicAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('panic_alerts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('location')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('created_rg')->nullable();
            $table->string('status_description')->nullable();
            $table->bigInteger('type_status_id')->unsigned();
            $table->foreign('type_status_id')->references('id')->on('references_table')->onDelete('cascade')
            ->onUpdate('cascade'); 
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')
            ->onUpdate('cascade'); 
            $table->timestamps();
        });

        Schema::create('panic_alerts_has_case', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->bigInteger('panic_alert_id')->unsigned();
            $table->foreign('panic_alert_id')->references('id')->on('panic_alerts')->onDelete('cascade')
            ->onUpdate('cascade'); 
            $table->bigInteger('case_id')->unsigned();
            $table->foreign('case_id')->references('id')->on('cases')->onDelete('cascade')
            ->onUpdate('cascade'); 
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
        Schema::dropIfExists('panic_alerts');
    }
}
