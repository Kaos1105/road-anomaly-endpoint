<?php

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\Contract\UnitClassificationEnum;
use App\Enums\Contract\RoundingMethodEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contract_individual_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('basic_contract_id')->constrained(
                table: 'contract_basic_contracts'
            )->cascadeOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('name', 100);
            $table->double('unit_price');
            $table->tinyInteger('unit_classification')->unsigned()->default(UnitClassificationEnum::COMPLETE_SET);
            $table->string('unit_name', 100)->nullable();
            $table->tinyInteger('rounding_method')->unsigned()->default(RoundingMethodEnum::HALF_UP);
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
        Schema::dropIfExists('contract_individual_contracts');
    }
};
