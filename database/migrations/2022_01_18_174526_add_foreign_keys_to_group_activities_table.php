<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToGroupActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group_activities', function (Blueprint $table) {
            $table->foreign(['id_trainer'], 'fk_group_activities_trainer1')->references(['id_trainer'])->on('trainer')->onUpdate('CASCADE')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('group_activities', function (Blueprint $table) {
            $table->dropForeign('fk_group_activities_trainer1');
        });
    }
}
