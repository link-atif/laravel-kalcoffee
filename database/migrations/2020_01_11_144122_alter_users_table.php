<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('contact_name')->nullable()->default(null)->after('name');
            $table->string('phone_number')->nullable()->default(null)->after('email');
            $table->text('address_1')->nullable()->default(null)->after('type');
            $table->text('address_2')->nullable()->default(null);
            $table->string('country')->nullable()->default(null);
            $table->string('city')->nullable()->default(null);
            $table->string('entity_age')->nullable()->default(null);
            $table->string('dealing_as')->nullable()->default(null);
            $table->string('interests')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('contact_name');
            $table->dropColumn('phone_number');
            $table->dropColumn('address_1');
            $table->dropColumn('address_2');
            $table->dropColumn('country');
            $table->dropColumn('city');
            $table->dropColumn('entity_age');
            $table->dropColumn('dealing_as');
            $table->dropColumn('interests');
        });
    }
}
