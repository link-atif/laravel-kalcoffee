<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('variety_id')->nullable()->default(null);
            $table->integer('process_id')->nullable()->default(null);
            $table->string('region')->nullable()->default(null);
            $table->string('altitude')->nullable()->default(null);
            $table->string('bag_size')->nullable()->default(null);
            $table->string('sample_size')->nullable()->default(null);
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
            $table->dropColumn('variety_id');
            $table->dropColumn('process_id');
            $table->dropColumn('region');
            $table->dropColumn('altitude');
            $table->dropColumn('bag_size');
            $table->dropColumn('sample_size');
        });
    }
}
