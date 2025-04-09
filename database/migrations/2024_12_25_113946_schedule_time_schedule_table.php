<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\Schedule\PublicClassificationEnum;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedule_time_schedule', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained(
                table: 'organization_employees'
            )->cascadeOnDelete();
            $table->date('date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('work_contents', 100)->nullable();
            $table->string('work_place', 100)->nullable();
            $table->integer('public_classification')->nullable()->default(PublicClassificationEnum::ALL_MEMBER);
            $table->bigInteger('public_group_id')->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->datetime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_time_schedule');
    }
};
