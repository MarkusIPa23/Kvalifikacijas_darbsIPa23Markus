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
        Schema::table('users', function (Blueprint $table): void {
            $table->text('bio')->nullable();
            $table->string('avatar_url', 2048)->nullable();
            $table->string('favorite_genre', 50)->nullable();
            $table->string('profile_color', 20)->default('teal');
            $table->boolean('profile_visibility')->default(true);
            $table->boolean('show_favorites')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn([
                'bio',
                'avatar_url',
                'favorite_genre',
                'profile_color',
                'profile_visibility',
                'show_favorites',
            ]);
        });
    }
};
