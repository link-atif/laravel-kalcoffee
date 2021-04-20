<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('user_email');
            $table->string('name');
            $table->string('city');
            $table->string('country');
            $table->text('address');
            $table->string('mobile');
            $table->float('shipping_charges');
            $table->text('coupon_code')->nullable()->default(null);
            $table->float('coupon_amount')->nullable()->default(null);
            $table->string('payment_method');
            $table->float('grand_total');
            $table->string('order_status');
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
        Schema::dropIfExists('orders');
    }
}
