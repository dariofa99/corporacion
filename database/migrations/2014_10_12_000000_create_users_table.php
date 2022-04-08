<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('identification_number')->nullable();
            $table->string('phone_number')->nullable();
            $table->boolean('status')->default(1);
            $table->string('email')->unique();
            $table->string('image')->nullable();
            $table->string('address')->nullable();
            $table->string('town')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->bigInteger('type_identification_id')->unsigned();
            $table->foreign('type_identification_id')->references('id')->on('references_table')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('type_status_id')->unsigned();
            $table->foreign('type_status_id')->references('id')->on('references_table')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
