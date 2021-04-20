<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductFieldsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('product_code');
            $table->string('harvest')->nullable()->default(null);
            $table->string('score')->nullable()->default(null);
            $table->string('cupping_notes')->default(null);
            $table->string('map')->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('harvest');
            $table->dropColumn('score');
            $table->dropColumn('cupping_notes');
            $table->dropColumn('map');
        });
    }
}
