<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductTicketsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_tickets', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('products_id')->default(0);
			$table->integer('id_event')->default(0);
			$table->integer('id_schedule')->default(0);
			$table->integer('id_group')->default(0);
			$table->integer('id_ticket')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_tickets');
	}

}
