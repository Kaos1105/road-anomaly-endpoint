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
        Schema::table('snet_answer_texts', function (Blueprint $table) {
            $table->renameColumn('answer_text', 'answer_content');
        });
        Schema::table('snet_answer_texts', function (Blueprint $table) {
            $table->text('answer_content')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('snet_answer_texts', function (Blueprint $table) {
            $table->text('answer_content')->nullable(false)->change();
        });
        Schema::table('snet_answer_texts', function (Blueprint $table) {
            $table->renameColumn('answer_content', 'answer_text');
        });
    }
};
