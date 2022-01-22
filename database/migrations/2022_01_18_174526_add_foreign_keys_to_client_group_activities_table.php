<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToClientGroupActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_group_activities', function (Blueprint $table) {
            $table->foreign(['id_group_activities'], 'fk_user_group_activities_group_activities1')->references(['id_group_activities'])->on('group_activities')->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->foreign(['id_client'], 'fk_user_group_activities_user1')->references(['id_client'])->on('client')->onUpdate('CASCADE')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_group_activities', function (Blueprint $table) {
            $table->dropForeign('fk_user_group_activities_group_activities1');
            $table->dropForeign('fk_user_group_activities_user1');
        });
    }
}
