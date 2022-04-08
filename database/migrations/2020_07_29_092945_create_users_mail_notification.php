<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersMailNotification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_mail_notification', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('show_notification_date')->nullable();  
            $table->string('token')->nullable();  
            $table->longText('access_address')->nullable(); 
            
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('caselog_id')->unsigned();
            $table->foreign('caselog_id')->references('id')->on('case_log')
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
        Schema::dropIfExists('users_mail_notification');
    }
}
