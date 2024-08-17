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
        // Beispiel: Neue Spalte mit einem größeren Feld
        $table->text('new_description')->nullable();
    });
}

public function down()
{
    Schema::table('rooms', function (Blueprint $table) {
        $table->dropColumn('new_description');
    });
}

};
