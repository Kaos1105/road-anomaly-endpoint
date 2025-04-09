<?php

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\Product\TaxRateEnum;
use App\Enums\SocialCustomer\AccountingCompanyClassificationEnum;
use App\Enums\SocialCustomer\AddressClassificationEnum;
use App\Enums\SocialCustomer\ProcessingSiteClassificationEnum;
use App\Enums\Workflow\WorkflowOrderEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('social_social_datas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('social_event_id')->constrained(
                table: 'social_social_events')->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained(
                table: 'social_customers')->cascadeOnDelete();
            $table->foreignId('display_transfer_id')->constrained(
                table: 'organization_transfers'
            )->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained(
                table: 'social_products')->cascadeOnDelete();
            $table->string('product_name', 100)->nullable();
            $table->double('unit_price')->nullable();
            $table->double('discount')->nullable();
            $table->tinyInteger('tax_classification_1')->unsigned()->default(TaxRateEnum::TEN_PERCENT);
            $table->double('tax_1')->nullable();
            $table->double('shipping_cost')->nullable();
            $table->tinyInteger('tax_classification_2')->unsigned()->default(TaxRateEnum::TEN_PERCENT);
            $table->double('tax_2')->nullable();
            $table->double('other')->nullable();
            $table->tinyInteger('tax_classification_3')->unsigned()->default(TaxRateEnum::TEN_PERCENT);
            $table->double('tax_3')->nullable();
            $table->double('total_amount')->nullable();
            $table->double('total_tax')->nullable();
            $table->text('purpose')->nullable();
            $table->text('result')->nullable();
            $table->tinyInteger('processing_site')->unsigned()->default(ProcessingSiteClassificationEnum::OKAYAMA);
            $table->tinyInteger('accounting_company')->unsigned()->default(AccountingCompanyClassificationEnum::SHINNICHIRO);
            $table->foreignId('accounting_department_id')->constrained(
                table: 'organization_departments')->cascadeOnDelete();
            $table->tinyInteger('address_classification')->unsigned()->default(AddressClassificationEnum::HOME);
            $table->tinyInteger('data_progress')->unsigned()->default(WorkflowOrderEnum::CREATE);
            $table->text('comment_history')->nullable();
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
        Schema::dropIfExists('social_social_datas');
    }
};
