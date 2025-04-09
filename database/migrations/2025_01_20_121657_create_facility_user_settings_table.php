<?php

use App\Enums\Facility\HolidayDisplayEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('facility_user_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(
                table: 'organization_employees'
            )->cascadeOnDelete();
            $table->tinyInteger('holiday_display')->unsigned()->default(HolidayDisplayEnum::DISPLAY);
            $table->foreignId('facility_group_id')->constrained(
                table: 'facility_facility_groups'
            )->cascadeOnDelete();
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
        Schema::dropIfExists('facility_user_settings');
    }
};
