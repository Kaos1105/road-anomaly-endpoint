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
        Schema::create('snet_chat_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_thread_id')->constrained(
                table: 'snet_chat_threads')->cascadeOnDelete();
            $table->foreignId('chat_content_id')->constrained(
                table: 'snet_chat_contents')->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained(
                table: 'organization_employees')->cascadeOnDelete();
            $table->tinyInteger('read_flag');
            $table->datetime('read_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('snet_chat_notifications');
    }
};
