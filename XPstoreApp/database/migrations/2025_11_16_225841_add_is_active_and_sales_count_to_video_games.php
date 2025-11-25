<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('video_games', function (Blueprint $table) {
            $table->boolean('is_active')->default(true);
            $table->integer('sales_count')->default(0);
        });
    }

    public function down()
    {
        Schema::table('video_games', function (Blueprint $table) {
            $table->dropColumn(['is_active', 'sales_count']);
        });
    }
};
