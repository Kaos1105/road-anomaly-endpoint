<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\FAQ\AnswerFileEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('snet_answer_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained(
                table: 'snet_questions')->cascadeOnDelete();
            $table->integer('display_order')->unsigned();
            $table->text('file_name');
            $table->text('file_path');
            $table->integer('width_size')->default(AnswerFileEnum::WIDTH_DEFAULT);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('snet_answer_files');
    }
};
