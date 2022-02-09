<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_info', function (Blueprint $table) {
            $table->integer('id_ticket_info', true);
            $table->string('ticket_type', 45)->nullable();
            $table->string('ticket_length', 45)->nullable();
            $table->string('description', 255)->nullable();
            $table->double('price', 11)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_info');
    }
}
