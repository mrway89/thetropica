<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVouchersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vouchers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('code', 191);
			$table->date('start_date');
			$table->date('end_date');
			$table->integer('limit_per_user')->default(1);
			$table->integer('quota')->default(1);
			$table->integer('discount');
			$table->integer('min_amount');
			$table->string('type', 191);
			$table->string('unit', 191);
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
		Schema::drop('vouchers');
	}

}
