<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->unsignedBigInteger('card_id');
            $table->foreign('card_id')->references('id')->on('cards');
            $table->integer('membership_type'); //  il tipo di abbonamento del cliente (e.g. base, intermedio, completo).
            $table->integer('membership_duration'); //  il tipo di abbonamento del cliente (e.g. mensile, trimestrale, annuale).
            $table->integer('membership_status'); // lo stato dell'abbonamento del cliente (e.g. attivo, scaduto, sospeso).
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
