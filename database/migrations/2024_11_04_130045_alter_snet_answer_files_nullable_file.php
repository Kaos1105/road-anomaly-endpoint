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
        Schema::table('snet_answer_files', function (Blueprint $table) {
            $table->text('file_name')->nullable()->change();
            $table->text('file_path')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('snet_answer_files', function (Blueprint $table) {
            $table->text('file_name')->change();
            $table->text('file_path')->change();
        });
    }
};
