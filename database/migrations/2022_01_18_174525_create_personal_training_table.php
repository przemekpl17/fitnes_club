<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalTrainingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_training', function (Blueprint $table) {
            $table->integer('id_personal_training', true);
            $table->dateTime('date_time_from')->nullable();
            $table->dateTime('date_time_to')->nullable();
            $table->integer('id_trainer')->nullable()->index('fk_personal_training_trainer1_idx');
            $table->integer('id_client')->nullable()->index('fk_personal_training_user_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal_training');
    }
}
