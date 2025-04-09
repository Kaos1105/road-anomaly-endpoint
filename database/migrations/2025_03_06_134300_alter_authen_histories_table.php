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
        Schema::table('snet_authen_histories', function (Blueprint $table) {
            $table->index('authen_at', 'idx_authen_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('snet_authen_histories', function (Blueprint $table) {
            $table->dropIndex('idx_authen_at');
        });
    }
};
