<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRhapsodieLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rhapsodie_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->nullable();
            $table->string('ipaddress')->nullable();
            $table->string('useragent')->nullable();
            $table->string('url')->nullable();
            $table->string('description')->nullable();
            $table->text('details')->nullable();
            $table->integer('id_cms_users')->nullable();
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
        Schema::dropIfExists('rhapsodie_logs');
    }
}
