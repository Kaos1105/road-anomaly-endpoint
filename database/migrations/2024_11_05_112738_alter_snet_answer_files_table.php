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
        Schema::table('snet_answer_files', function (Blueprint $table) {
            $table->dropColumn('file_name');
            $table->dropColumn('file_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('snet_answer_files', function (Blueprint $table) {
            $table->text('file_name')->nullable();
            $table->text('file_path')->nullable();
        });
    }
};
