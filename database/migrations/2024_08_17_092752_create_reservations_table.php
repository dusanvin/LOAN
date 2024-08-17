<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained()->onDelete('cascade'); // Verknüpft mit der rooms-Tabelle
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Verknüpft mit der users-Tabelle
            $table->date('start_date'); // Startdatum der Reservierung
            $table->date('end_date'); // Enddatum der Reservierung
            $table->timestamps(); // Erstellungs- und Aktualisierungszeiten
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
};
