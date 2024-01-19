<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
            $table->increments('id');
            $table->string('provider', 191)->nullable();
            $table->string('register_id', 191)->nullable();
            $table->string('title', 191)->nullable();
            $table->string('name', 191)->nullable();
            $table->integer('age')->nullable();
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('phone', 191)->unique();
            $table->string('email', 191)->unique();
            $table->string('password', 191)->nullable();
            $table->string('verification_code', 191)->nullable();
            $table->boolean('verification_status')->default(0);
            $table->string('socialite_token', 191)->nullable();
            $table->string('socialite_refresh_token', 191)->nullable();
            $table->string('socialite_expires_in', 191)->nullable();
            $table->string('avatar', 191)->nullable();
            $table->string('socialite_avatar', 191)->nullable();
            $table->boolean('is_subscribe')->default(1);
            $table->string('remember_token', 191)->nullable();
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
        Schema::drop('users');
    }
}
