<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientGroupActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_group_activities', function (Blueprint $table) {
            $table->integer('id_client_group_activities', true);
            $table->integer('id_client')->nullable()->index('fk_user_group_activities_user1_idx');
            $table->integer('id_group_activities')->nullable()->index('fk_user_group_activities_group_activities1_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_group_activities');
    }
}
