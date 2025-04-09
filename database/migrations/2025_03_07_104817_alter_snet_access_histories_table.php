<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('snet_access_histories', function (Blueprint $table) {
            $table->index('access_at', 'idx_access_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('snet_access_histories', function (Blueprint $table) {
            $table->dropIndex('idx_access_at');
        });
    }
};
