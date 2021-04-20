<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCartFieldsToCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cart', function (Blueprint $table) {
            $table->string('image',150)->nullable()->default(null);
            $table->date('schedule_date')->nullable()->default(null);
            $table->string('level_name', 100)->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cart', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->dropColumn('schedule_date');
            $table->dropColumn('level_name');
        });
    }
}
