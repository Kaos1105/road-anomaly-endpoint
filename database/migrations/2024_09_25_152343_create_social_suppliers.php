<?php

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\Supplier\SupplierClassificationEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('social_suppliers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_store_id')->constrained(
                table: 'organization_sites')->cascadeOnDelete();
            $table->tinyInteger('supplier_classification')->unsigned()->default(SupplierClassificationEnum::FOOD);
            $table->foreignId('supplier_person_id')->constrained(
                table: 'organization_employees')->cascadeOnDelete();
            $table->foreignId('my_company_person_id')->constrained(
                table: 'organization_employees')->cascadeOnDelete();
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
        Schema::dropIfExists('social_suppliers');
    }
};
