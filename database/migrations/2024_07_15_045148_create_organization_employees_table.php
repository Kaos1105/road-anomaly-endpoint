<?php

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\PreviousNameFlagEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\Employee\GenderEnum;
use App\Enums\Employee\PeriodAccuracyFlagEnum;
use App\Enums\Employee\EmployeeClassificationEnum;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('organization_employees', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->nullable();
            $table->string('last_name', 100);
            $table->string('first_name', 100);
            $table->string('kana', 100)->nullable();
            $table->date('day_of_birth')->default(Carbon::now());
            $table->date('day_of_death')->nullable();
            $table->tinyInteger('period_accuracy_flg')->unsigned()->default(PeriodAccuracyFlagEnum::CORRECT);
            $table->tinyInteger('employees_classification')->unsigned()->default(EmployeeClassificationEnum::EMPLOYEE);
            $table->string('maiden_name', 100)->nullable();
            $table->tinyInteger('previous_name_flg')->unsigned()->default(PreviousNameFlagEnum::NOT_COMBINED);
            $table->tinyInteger('gender')->unsigned()->default(GenderEnum::MALE);
            $table->text('romaji')->nullable();
            $table->string('company_email', 100)->nullable();
            $table->string('company_phone', 20)->nullable();
            $table->string('post_code', 20)->nullable();
            $table->string('address_1', 100)->nullable();
            $table->string('address_2', 100)->nullable();
            $table->string('address_3', 100)->nullable();
            $table->string('phone', 20);
            $table->string('email', 100);
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
        Schema::dropIfExists('organization_employees');
    }
};
