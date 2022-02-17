<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id_users', true);
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->timestamps();
            $table->integer('account_type')->default(0);
            $table->integer('id_trainer')->nullable()->index('fk_auth_trainer1_idx');
            $table->integer('id_client')->nullable()->index('fk_auth_user1_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
