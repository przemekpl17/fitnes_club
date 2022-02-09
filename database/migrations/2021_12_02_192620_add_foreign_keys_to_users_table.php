<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign(['id_trainer'], 'fk_auth_trainer1')->references(['id_trainer'])->on('trainer')->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->foreign(['id_client'], 'fk_auth_user1')->references(['id_client'])->on('client')->onUpdate('CASCADE')->onDelete('SET NULL');
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
            $table->dropForeign('fk_auth_trainer1');
            $table->dropForeign('fk_auth_user1');
        });
    }
}
