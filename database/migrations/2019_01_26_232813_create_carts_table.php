<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCartsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('carts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('type', 191);
			$table->integer('user_id');
			$table->enum('status', array('checkout','current','abadoned'))->nullable()->default('current');
			$table->integer('total_qty')->nullable();
			$table->integer('total_weight');
			$table->integer('total_price');
			$table->text('note', 65535)->nullable();
			$table->integer('user_address_id')->nullable();
			$table->string('courier_type_id', 11)->nullable();
			$table->integer('courier_cost')->nullable();
			$table->integer('voucher_id')->nullable();
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
		Schema::drop('carts');
	}

}
