<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('negotiation_client_employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained(
                table: 'organization_employees'
            )->cascadeOnDelete();
            $table->foreignId('client_site_id')->constrained(
                table: 'negotiation_client_sites'
            )->cascadeOnDelete();
            $table->string('role', 100);
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
        Schema::dropIfExists('negotiation_client_employees');
    }
};
