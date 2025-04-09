<?php

use App\Enums\Workflow\ExecutionCreateEnum;
use App\Enums\Workflow\WorkflowOrderEnum;
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
        Schema::create('social_workflows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('social_data_id')->constrained(
                table: 'social_social_datas')->cascadeOnDelete();
            $table->tinyInteger('workflow_order')->unsigned()->default(WorkflowOrderEnum::CREATE);
            $table->foreignId('scheduled_person_id')->constrained(
                table: 'organization_employees')->cascadeOnDelete();
            $table->foreignId('executor_id')->nullable()->constrained(
                table: 'organization_employees')->cascadeOnDelete();
            $table->tinyInteger('execution_type')->unsigned()->default(ExecutionCreateEnum::UNPROCESS);
            $table->timestamp('execution_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_workflows');
    }
};
