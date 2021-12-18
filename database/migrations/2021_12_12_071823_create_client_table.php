<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client', function (Blueprint $table) {
            $table->integer('id_client', true);
            $table->string('name', 45)->nullable();
            $table->string('surname', 45)->nullable();
            $table->char('gender', 1)->nullable();
            $table->integer('telephone')->nullable();
            $table->string('email', 55)->nullable();
            $table->string('city', 55)->nullable();
            $table->string('street', 55)->nullable();
            $table->integer('street_number')->nullable();
            $table->string('post_code', 6)->nullable();
            $table->double('account_balance')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client');
    }
}
