<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->float('price')->nullable()->default(null);
            $table->integer('points')->nullable()->default(null);
            $table->string('duration')->nullable()->default(null);
            $table->string('levels')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->dropColumn('points');
            $table->dropColumn('duration');
            $table->dropColumn('levels');
        });
    }
}
