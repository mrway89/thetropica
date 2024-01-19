<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 191)->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('brand_id')->nullable();
            $table->string('slug', 191)->nullable();
            $table->text('description', 65535)->nullable();
            $table->text('information', 65535)->nullable();
            $table->text('specification', 65535)->nullable();
            $table->bigInteger('price')->nullable();
            $table->bigInteger('discounted_price')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('stock')->nullable();
            $table->integer('sold')->nullable()->default(0);
            $table->string('sku', 191)->nullable();
            $table->text('features', 65535)->nullable();
            $table->boolean('is_active')->nullable()->default(1);
            $table->string('type', 191)->nullable()->default('product');
            $table->integer('id_ticket')->nullable();
            $table->text('tags', 65535)->nullable();
            $table->boolean('is_rds')->nullable()->default(0);
            $table->bigInteger('view')->nullable()->default(0);
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
        Schema::drop('products');
    }
}
