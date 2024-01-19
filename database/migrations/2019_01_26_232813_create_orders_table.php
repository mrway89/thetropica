<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_code', 191);
            $table->integer('user_id');
            $table->integer('cart_id')->nullable()->comment('if zero = guest');
            $table->string('status', 191)->comment('Pending, New, Sent, Received, Completed, Returned');
            $table->string('payment_method', 191)->comment('ex. Bank Transfer');
            $table->dateTime('payment_date')->nullable();
            $table->integer('payment_status')->default(0)->comment('0 = Unpaid, 1 = Paid');
            $table->bigInteger('subtotal');
            $table->integer('total_weight');
            $table->integer('total_shipping_cost')->comment('round(total_weight)*order_shipping_method.cost');
            $table->integer('grand_total')->comment('subtotal + tax + total_shipping_cost + payment_fee - voucher_value');
            $table->text('notes', 65535)->nullable();
            $table->integer('voucher_id')->nullable();
            $table->string('voucher_code', 191)->nullable();
            $table->integer('voucher_value')->nullable();
            $table->string('voucher_unit', 191)->nullable();
            $table->string('voucher_type', 191)->nullable();
            $table->string('no_resi', 191)->nullable();
            $table->datetime('delivery_date')->nullable();
            $table->text('midtrans', 65535)->nullable();
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
        Schema::drop('orders');
    }
}
