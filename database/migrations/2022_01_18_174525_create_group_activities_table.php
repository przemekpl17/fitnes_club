<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_activities', function (Blueprint $table) {
            $table->integer('id_group_activities', true);
            $table->string('name', 45)->nullable();
            $table->dateTime('date_time_from')->nullable();
            $table->dateTime('date_time_to')->nullable();
            $table->integer('room_number')->nullable();
            $table->integer('max_participants')->nullable();
            $table->integer('enrolled_participants')->nullable();
            $table->integer('id_trainer')->nullable()->index('fk_group_activities_trainer1_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_activities');
    }
}
