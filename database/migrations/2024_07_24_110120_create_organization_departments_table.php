<?php

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\PreviousNameFlagEnum;
use App\Enums\Common\RepresentFlagEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\Department\DepartmentClassificationEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('organization_departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained(
                table: 'organization_sites'
            )->cascadeOnDelete();
            $table->string('code', 20)->nullable();
            $table->string('long_name', 100);
            $table->string('short_name', 100)->nullable();
            $table->string('kana', 100)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->tinyInteger('represent_flg')->unsigned()->default(RepresentFlagEnum::NOT_SPECIFIED);
            $table->tinyInteger('department_classification')->unsigned()->default(DepartmentClassificationEnum::GENERAL_AFFAIRS);
            $table->string('previous_name', 100)->nullable();
            $table->tinyInteger('previous_name_flg')->unsigned()->default(PreviousNameFlagEnum::NOT_COMBINED);
            $table->string('en_notation', 100)->nullable();
            $table->string('phone', 20)->nullable();
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
        Schema::dropIfExists('organization_departments');
    }
};
