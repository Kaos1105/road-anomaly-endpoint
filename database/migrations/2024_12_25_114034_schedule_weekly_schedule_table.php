<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\Schedule\DisplayWeeklyClassificationEnum;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedule_weekly_schedule', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(
                table: 'organization_employees'
            )->cascadeOnDelete();
            $table->foreignId('display_employee_id')->constrained(
                table: 'organization_employees'
            )->cascadeOnDelete();
            $table->integer('display_order');
            $table->integer('display_weekly_classification')->unsigned()->nullable()->default(DisplayWeeklyClassificationEnum::THIS_WEEK);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_weekly_schedule');
    }
};
