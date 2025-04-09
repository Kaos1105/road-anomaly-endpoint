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
        Schema::table('snet_answer_files', function (Blueprint $table) {
            $table->integer('width_size')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('snet_answer_files', function (Blueprint $table) {
            $table->integer('width_size')->nullable()->default(AnswerFileEnum::WIDTH_DEFAULT)->change();
        });
    }
};
