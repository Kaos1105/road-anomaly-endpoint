<?php

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('social_event_classifications', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20)->unique();
            $table->text('description')->nullable();
            $table->text('operation_rule')->nullable();
            $table->text('social_criteria')->nullable();
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
        Schema::dropIfExists('social_event_classifications');
    }
};
