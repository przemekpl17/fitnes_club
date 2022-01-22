<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainer', function (Blueprint $table) {
            $table->integer('id_trainer', true);
            $table->string('name', 45)->nullable();
            $table->string('surname', 45)->nullable();
            $table->char('gender', 1)->nullable();
            $table->string('email', 55)->nullable();
            $table->integer('telephone')->nullable();
            $table->string('city', 55)->nullable();
            $table->string('street', 55)->nullable();
            $table->string('street_num', 30)->nullable();
            $table->string('post_code', 6)->nullable();
            $table->integer('training_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trainer');
    }
}
