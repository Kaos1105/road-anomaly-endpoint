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
        Schema::create('common_attachment_files', function (Blueprint $table) {
            $table->id();
            $table->morphs('attachable');
            $table->text('file_name');
            $table->text('file_path');
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->datetime('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('common_attachment_files');
    }
};
