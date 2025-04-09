<?php

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\Contract\ConditionClassificationEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contract_contract_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('basic_contract_id')->constrained(
                table: 'contract_basic_contracts'
            )->cascadeOnDelete();
            $table->smallInteger('condition_classification')->unsigned()->default(ConditionClassificationEnum::PURPOSE);
            $table->string('code', 20);
            $table->text('content');
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
        Schema::dropIfExists('contract_contract_conditions');
    }
};
