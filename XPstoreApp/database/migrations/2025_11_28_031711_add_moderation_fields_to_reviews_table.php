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
        Schema::table('reviews', function (Blueprint $table) {
            $table->boolean('is_blocked')->default(false)->after('helpful');
            $table->text('warning_message')->nullable()->after('is_blocked');
            $table->enum('sentiment', ['bueno', 'medio', 'malo'])->nullable()->after('warning_message');
            $table->timestamp('moderated_at')->nullable()->after('sentiment');
            $table->unsignedBigInteger('moderated_by')->nullable()->after('moderated_at');

            $table->foreign('moderated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['moderated_by']);
            $table->dropColumn(['is_blocked', 'warning_message', 'sentiment', 'moderated_at', 'moderated_by']);
        });
    }
};
