<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGosendTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gosend_tracks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('orderNo')->nullable();
            $table->string('status')->nullable();
            $table->string('driverId')->nullable();
            $table->string('driverName')->nullable();
            $table->string('driverPhone')->nullable();
            $table->string('driverPhoto')->nullable();
            $table->string('vehicleNumber')->nullable();
            $table->string('totalDiscount')->nullable();
            $table->string('totalPrice')->nullable();
            $table->string('receiverName')->nullable();
            $table->dateTime('orderCreatedTime')->nullable();
            $table->dateTime('orderDispatchTime')->nullable();
            $table->dateTime('orderArrivalTime')->nullable();
            $table->dateTime('orderClosedTime')->nullable();
            $table->string('sellerAddressName')->nullable();
            $table->text('sellerAddressDetail')->nullable();
            $table->string('buyerAddressName')->nullable();
            $table->text('buyerAddressDetail')->nullable();
            $table->string('bookingType')->nullable();
            $table->string('cancelDescription')->nullable();
            $table->string('storeOrderId')->nullable();
            $table->string('liveTrackingUrl')->nullable();
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
        Schema::dropIfExists('gosend_tracks');
    }
}
