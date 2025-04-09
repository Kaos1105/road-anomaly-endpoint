<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\Facility\FacilityClassificationEnum;
use App\Enums\Facility\AggregationClassificationEnum;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('facility_facilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('facility_group_id')->constrained(
                table: 'facility_facility_groups'
            )->cascadeOnDelete();
            $table->foreignId('responsible_user_id')->constrained(
                table: 'organization_employees'
            )->cascadeOnDelete();
            $table->text('usage_method')->nullable();
            $table->string('name', 100);
            $table->integer('facility_classification')->unsigned()->default(FacilityClassificationEnum::MEETING_ROOM);
            $table->integer('aggregation_classification')->unsigned()->default(AggregationClassificationEnum::AGGREGATION);
            $table->integer('display_order')->unsigned()->default(DisplayOrderEnum::DEFAULT);
            $table->tinyInteger('use_classification')->unsigned()->default(UseFlagEnum::USE);
            $table->text('memo')->nullable();
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
        Schema::dropIfExists('facility_facilities');
    }
};
