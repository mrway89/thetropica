<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->nullable();
            $table->integer('item_id')->nullable();
            $table->string('title_id')->nullable();
            $table->string('title_end')->nullable();
            $table->string('subtitle_id')->nullable();
            $table->string('subtitle_en')->nullable();
            $table->string('url')->nullable();
            $table->boolean('is_featured')->nullable()->default(0);
            $table->string('link')->nullable();
            $table->integer('sorting')->nullable();
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
        Schema::drop('images');
    }
}
