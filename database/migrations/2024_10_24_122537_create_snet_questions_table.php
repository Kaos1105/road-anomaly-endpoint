<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\AccessPermission\Permission2FlagEnum;
use App\Enums\AccessPermission\Permission3FlagEnum;
use App\Enums\AccessPermission\Permission4FlagEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('snet_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('display_id')->constrained(
                table: 'snet_displays')->cascadeOnDelete();
            $table->string('code', 20);
            $table->string('classification', 100);
            $table->string('title', 100);
            $table->tinyInteger('permission_2')->unsigned()->default(Permission2FlagEnum::DATA_VIEWING);
            $table->tinyInteger('permission_3')->unsigned()->default(Permission3FlagEnum::GENERAL_INFORMATION);
            $table->tinyInteger('permission_4')->unsigned()->default(Permission4FlagEnum::AFFILIATED_DIVISION);
            $table->foreignId('similar_faq_1_id')
                ->nullable()
                ->constrained('snet_questions')
                ->nullOnDelete();
            $table->foreignId('similar_faq_2_id')
                ->nullable()
                ->constrained('snet_questions')
                ->nullOnDelete();
            $table->foreignId('similar_faq_3_id')
                ->nullable()
                ->constrained('snet_questions')
                ->nullOnDelete();
            $table->text('memo')->nullable();
            $table->integer('display_order')->unsigned()->default(DisplayOrderEnum::DEFAULT);
            $table->tinyInteger('use_classification')->unsigned()->default(UseFlagEnum::USE);
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('snet_questions');
    }
};
