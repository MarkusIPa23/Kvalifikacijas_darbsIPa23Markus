<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('game_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('game_id');
            $table->string('game_title')->nullable();
            $table->unsignedTinyInteger('rating');
            $table->timestamps();

            $table->unique(['user_id', 'game_id']);
            $table->index('game_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_ratings');
    }
};
