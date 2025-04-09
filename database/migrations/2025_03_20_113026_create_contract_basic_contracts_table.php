<?php

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\Contract\PresidentApprovalStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contract_basic_contracts', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->date('signing_at');
            $table->foreignId('counterparty_id')->constrained(
                table: 'organization_sites'
            )->cascadeOnDelete();
            $table->foreignId('counterparty_contractor_id')->nullable()->constrained(
                table: 'organization_employees'
            )->cascadeOnDelete();
            $table->foreignId('counterparty_representative_id')->nullable()->constrained(
                table: 'organization_employees'
            )->cascadeOnDelete();
            $table->foreignId('site_id')->constrained(
                table: 'organization_sites'
            )->cascadeOnDelete();
            $table->foreignId('contractor_id')->constrained(
                table: 'organization_employees'
            )->cascadeOnDelete();
            $table->foreignId('representative_id')->constrained(
                table: 'organization_employees'
            )->cascadeOnDelete();
            $table->string('no', 50)->nullable();
            $table->string('name', 100);
            $table->tinyInteger('approval_flag')->unsigned()->default(PresidentApprovalStatusEnum::NOT_APPROVED);
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
        Schema::dropIfExists('contract_basic_contracts');
    }
};
