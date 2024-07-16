<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('device_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained()->onDelete('cascade');
            $table->string('action');
            $table->string('user_name');
            $table->string('action_by');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('device_histories');
    }
}
