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
    Schema::table('rooms', function (Blueprint $table) {
        $table->string('new_column'); // Füge eine neue Spalte hinzu
        // Weitere Änderungen
    });
}

public function down()
{
    Schema::table('rooms', function (Blueprint $table) {
        $table->dropColumn('new_column'); // Rückgängig machen der Änderungen
    });
}

};
