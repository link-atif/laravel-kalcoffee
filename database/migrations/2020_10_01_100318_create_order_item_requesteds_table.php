<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemRequestedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_item_requesteds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id');
            $table->string('product_id');
            $table->string('order_id');
            $table->string('quantity');
            $table->string('remaining');
            $table->string('sub_total');
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
        Schema::dropIfExists('order_item_requesteds');
    }
}
