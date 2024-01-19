<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('type', 191)->nullable();
            $table->integer('category_id')->nullable();
            $table->string('title', 191)->nullable();
            $table->text('content_id')->nullable();
            $table->text('content_en')->nullable();
            $table->text('other_content')->nullable();
            $table->string('slug', 191)->nullable();
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
        Schema::drop('contents');
    }
}
