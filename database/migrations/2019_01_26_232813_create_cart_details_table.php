<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCartDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cart_details', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('cart_id');
			$table->integer('product_id');
			$table->string('product_name', 191);
			$table->integer('product_price');
			$table->integer('product_weight');
			$table->integer('qty')->unsigned()->default(1);
			$table->string('loketcom_token', 191)->nullable();
			$table->string('order_result', 191)->nullable();
			$table->dateTime('token_expired')->nullable();
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
		Schema::drop('cart_details');
	}

}
