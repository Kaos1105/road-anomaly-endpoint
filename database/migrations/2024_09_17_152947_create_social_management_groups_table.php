<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('social_management_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('sender_post_code', 20)->nullable();
            $table->string('sender_address_1', 100)->nullable();
            $table->string('sender_address_2', 100)->nullable();
            $table->string('sender_address_3', 100)->nullable();
            $table->string('sender_name', 20)->nullable();
            $table->string('contact_point', 100)->nullable();
            $table->string('contact_phone', 20)->nullable();
            $table->foreignId('preparatory_personnel_id')->constrained(
                table: 'organization_employees'
            )->cascadeOnDelete();
            $table->foreignId('applicant_id')->constrained(
                table: 'organization_employees'
            )->cascadeOnDelete();
            $table->foreignId('approver_id')->constrained(
                table: 'organization_employees'
            )->cascadeOnDelete();
            $table->foreignId('final_decision_maker_id')->constrained(
                table: 'organization_employees'
            )->cascadeOnDelete();
            $table->foreignId('ordering_personnel_id')->constrained(
                table: 'organization_employees'
            )->cascadeOnDelete();
            $table->foreignId('payment_personnel_id')->constrained(
                table: 'organization_employees'
            )->cascadeOnDelete();
            $table->foreignId('completion_personnel_id')->constrained(
                table: 'organization_employees'
            )->cascadeOnDelete();
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
        Schema::dropIfExists('social_management_groups');
    }
};
