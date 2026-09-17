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
            $table->string('preferred_platform', 30)->nullable()->after('favorite_genre');
            $table->string('play_style', 30)->nullable()->after('preferred_platform');
            $table->string('gaming_status', 50)->nullable()->after('play_style');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn([
                'preferred_platform',
                'play_style',
                'gaming_status',
            ]);
        });
    }
};
