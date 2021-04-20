<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTrainingCartFieldsToCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cart', function (Blueprint $table) {
            $table->integer('course_id')->nullable()->default(null);
            $table->integer('level_id')->nullable()->default(null);
            $table->integer('schedule_id')->nullable()->default(null);
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
            $table->dropColumn('course_id');
            $table->dropColumn('level_id');
            $table->dropColumn('schedule_id');
        });
    }
}
