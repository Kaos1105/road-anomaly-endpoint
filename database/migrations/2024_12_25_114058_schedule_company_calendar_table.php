<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\Schedule\WorkClassificationEnum;
use App\Enums\Schedule\CalendarClassificationEnum;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedule_company_calendar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained(
                table: 'organization_companies'
            )->cascadeOnDelete();
            $table->date('date');
            $table->integer('calendar_classification')->unsigned()->nullable()->default(CalendarClassificationEnum::SUNDAY_HOLIDAY);
            $table->string('calendar_contents', 20)->nullable();
            $table->integer('work_classification')->unsigned()->nullable()->default(WorkClassificationEnum::DAY_OFF);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_company_calendar');
    }
};
