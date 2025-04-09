<?php

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\Product\ProductClassificationEnum;
use App\Enums\Product\TaxRateEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('social_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained(
                table: 'social_suppliers')->cascadeOnDelete();
            $table->tinyInteger('product_classification')->unsigned()->default(ProductClassificationEnum::FOOD);
            $table->string('code', 20)->nullable();
            $table->string('name', 100);
            $table->double('unit_price')->nullable();
            $table->tinyInteger('tax_classification_1')->unsigned()->default(TaxRateEnum::TEN_PERCENT);
            $table->tinyInteger('tax_classification_2')->unsigned()->default(TaxRateEnum::TEN_PERCENT);
            $table->tinyInteger('tax_classification_3')->unsigned()->default(TaxRateEnum::TEN_PERCENT);
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
        Schema::dropIfExists('social_products');
    }
};
