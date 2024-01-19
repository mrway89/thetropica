<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExperienceContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experience_contents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image')->nullable();
            $table->string('title_id')->nullable();
            $table->string('title_en')->nullable();
            $table->string('subtitle_id')->nullable();
            $table->string('subtitle_en')->nullable();
            $table->text('content_id')->nullable();
            $table->text('content_en')->nullable();
            $table->string('link1')->nullable();
            $table->string('link2')->nullable();
            $table->string('type')->nullable();
            $table->string('slug')->nullable();
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
        Schema::dropIfExists('experience_contents');
    }
}
