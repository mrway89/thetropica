<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categories', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('parent_id')->nullable()->default(0);
			$table->string('title', 191);
			$table->string('slug', 191);
			$table->text('description', 65535);
			$table->string('icon_image', 191)->nullable();
			$table->string('cover_image', 191)->nullable();
			$table->string('banner_image', 191)->nullable();
			$table->string('banner_link', 191)->nullable();
			$table->string('type', 191);
			$table->boolean('is_featured')->nullable()->default(0);
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
		Schema::drop('categories');
	}

}
