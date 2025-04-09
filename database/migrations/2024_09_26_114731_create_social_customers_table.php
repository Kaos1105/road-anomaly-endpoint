<?php

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\SocialCustomer\ProcessingSiteClassificationEnum;
use App\Enums\SocialCustomer\AccountingCompanyClassificationEnum;
use App\Enums\SocialCustomer\AddressClassificationEnum;
use App\Enums\SocialCustomer\AddressPrintingClassificationEnum;
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
        Schema::create('social_customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained(
                table: 'organization_employees'
            )->cascadeOnDelete();
            $table->foreignId('display_transfer_id')->constrained(
                table: 'organization_transfers'
            )->cascadeOnDelete();
            $table->foreignId('responsible_id')->constrained(
                table: 'organization_employees'
            )->cascadeOnDelete();
            $table->string('category_name', 100);

            $table->tinyInteger('processing_site')->unsigned()->default(ProcessingSiteClassificationEnum::OKAYAMA);
            $table->tinyInteger('accounting_company')->unsigned()->default(AccountingCompanyClassificationEnum::SHINNICHIRO);
            $table->foreignId('accounting_department_id')->constrained(
                table: 'organization_departments'
            )->cascadeOnDelete();
            $table->integer('address_classification')->unsigned()->default(AddressClassificationEnum::HOME);
            $table->boolean('address_printing_1')->default(AddressPrintingClassificationEnum::TRUE);
            $table->boolean('address_printing_2')->default(AddressPrintingClassificationEnum::TRUE);
            $table->boolean('address_printing_3')->default(AddressPrintingClassificationEnum::TRUE);
            $table->boolean('address_printing_4')->default(AddressPrintingClassificationEnum::TRUE);
            $table->boolean('address_printing_5')->default(AddressPrintingClassificationEnum::TRUE);
            $table->boolean('address_printing_6')->default(AddressPrintingClassificationEnum::TRUE);
            $table->string('specified_post_code', 10)->nullable();
            $table->string('specified_address_1', 100)->nullable();
            $table->string('specified_address_2', 100)->nullable();
            $table->string('specified_address_3', 100)->nullable();
            $table->string('specified_phone', 20)->nullable();
            $table->text('update_order')->nullable();
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
        Schema::dropIfExists('social_customers');
    }
};
