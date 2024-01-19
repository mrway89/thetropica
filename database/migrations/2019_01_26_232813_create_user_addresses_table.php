<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserAddressesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_addresses', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->string('label', 191)->nullable();
			$table->string('name', 191)->nullable();
			$table->integer('province_id')->nullable();
			$table->string('province', 191)->nullable();
			$table->integer('city_id')->nullable();
			$table->string('city', 191)->nullable();
			$table->integer('subdistrict_id')->nullable();
			$table->string('subdistrict', 191)->nullable();
			$table->string('postal_code', 191)->nullable();
			$table->text('address', 65535)->nullable();
			$table->string('phone_number', 191)->nullable();
			$table->boolean('is_default')->nullable()->default(0);
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
		Schema::drop('user_addresses');
	}

}
