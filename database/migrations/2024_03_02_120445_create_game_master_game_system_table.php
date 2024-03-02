<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('game_master_game_system', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_master_id');
            $table->unsignedBigInteger('game_system_id');
            $table->timestamps();

            $table->foreign('game_master_id')->references('id')->on('game_masters')->onDelete('cascade');
            $table->foreign('game_system_id')->references('id')->on('game_systems')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_master_game_system');
    }
};
