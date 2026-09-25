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
        Schema::table('video_games', function (Blueprint $table) {
            $table->integer('popularity')->default(0)->after('sales_count');
            $table->index('popularity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('video_games', function (Blueprint $table) {
            $table->dropIndex(['popularity']);
            $table->dropColumn('popularity');
        });
    }
};
