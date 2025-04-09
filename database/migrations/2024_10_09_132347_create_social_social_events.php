<?php

use App\Enums\Common\UseFlagEnum;
use App\Enums\SocialEvent\EventProgressClassificationEnum;
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
        Schema::create('social_social_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained(
                table: 'social_management_groups')->cascadeOnDelete();
            $table->foreignId('event_id')->constrained(
                table: 'social_event_classifications')->cascadeOnDelete();
            $table->string('event_title', 100);
            $table->tinyInteger('event_progress')->unsigned()->default(EventProgressClassificationEnum::IN_PREPARATION);
            $table->date('planned_start');
            $table->date('creation_deadline');
            $table->date('approval_deadline');
            $table->date('order_deadline');
            $table->date('planned_completion');
            $table->text('plan_comment')->nullable();
            $table->text('actual_comment')->nullable();
            $table->text('memo')->nullable();
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
        Schema::dropIfExists('social_social_events');
    }
};
