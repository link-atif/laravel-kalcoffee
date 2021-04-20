<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlanRequestToPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn('category_id');
            $table->dropColumn('type');
            $table->dropColumn('recommendation');
            $table->string('entity_name');
            $table->string('requirement')->nullable()->default(null);
            $table->string('contact_name');
            $table->string('entity_age')->nullable()->default(null);
            $table->string('dealing_as')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn('entity_name');
            $table->dropColumn('requirement');
            $table->dropColumn('contact_name');
            $table->dropColumn('entity_age');
            $table->dropColumn('dealing_as');
        });
    }
}
