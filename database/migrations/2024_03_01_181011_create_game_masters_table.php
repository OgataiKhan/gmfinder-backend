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
        Schema::create('game_masters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('location', 100);
            $table->text('game_description');
            $table->tinyInteger('max_players')->nullable();
            $table->string('profile_img')->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('is_available')->default(1);
            $table->string('slug')->unique();
            $table->timestamps();
            // Set foreign key constraint with users table
            $table->foreign('user_id')->references('id')->on('users')
                  ->onDelete('cascade');
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_masters');
    }
};
