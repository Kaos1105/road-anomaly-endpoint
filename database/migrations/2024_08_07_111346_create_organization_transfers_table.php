<?php

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\RepresentFlagEnum;
use App\Enums\Transfer\MajorHistoryEnum;
use App\Enums\Transfer\ContractClassificationEnum;
use App\Enums\Transfer\TransferClassificationEnum;
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
        Schema::create('organization_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained(
                table: 'organization_companies'
            )->cascadeOnDelete();
            $table->foreignId('site_id')->constrained(
                table: 'organization_sites'
            )->cascadeOnDelete();
            $table->foreignId('department_id')->constrained(
                table: 'organization_departments'
            )->cascadeOnDelete();
            $table->foreignId('division_id')->constrained(
                table: 'organization_divisions'
            )->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained(
                table: 'organization_employees'
            )->cascadeOnDelete();
            $table->string('team_name', 100)->nullable();
            $table->string('position', 100)->nullable();
            $table->tinyInteger('contract_classification')->nullable()->unsigned()->default(ContractClassificationEnum::INDEFINITE);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->tinyInteger('represent_flg')->unsigned()->default(RepresentFlagEnum::NOT_SPECIFIED);
            $table->tinyInteger('transfer_classification')->unsigned()->default(TransferClassificationEnum::JOINING_COMPANY);
            $table->tinyInteger('major_history_flg')->unsigned()->default(MajorHistoryEnum::MAJOR_PERSONAL_CHANGES);
            $table->text('memo')->nullable();
            $table->integer('display_order')->unsigned()->default(DisplayOrderEnum::DEFAULT);
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
        Schema::dropIfExists('organization_transfers');
    }
};
