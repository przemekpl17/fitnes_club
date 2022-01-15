<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPersonalTrainingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('personal_training', function (Blueprint $table) {
            $table->foreign(['id_trainer'], 'fk_personal_training_trainer1')->references(['id_trainer'])->on('trainer')->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->foreign(['id_client'], 'fk_personal_training_user')->references(['id_client'])->on('client')->onUpdate('CASCADE')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personal_training', function (Blueprint $table) {
            $table->dropForeign('fk_personal_training_trainer1');
            $table->dropForeign('fk_personal_training_user');
        });
    }
}
