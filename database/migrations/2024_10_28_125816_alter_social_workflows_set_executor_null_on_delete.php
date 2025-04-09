<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the existing foreign key constraint
        Schema::table('social_workflows', function (Blueprint $table) {
            // Assuming the name of the foreign key constraint is social_workflows_executor_id_foreign
            $table->dropForeign(['executor_id']);
            $table->dropColumn('executor_id');
        });

        // Re-add the foreign key constraint with on delete set to null
        Schema::table('social_workflows', function (Blueprint $table) {
            $table->foreignId('executor_id')->after('scheduled_person_id')->nullable()->constrained(
                table: 'organization_employees')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('social_workflows', function (Blueprint $table) {
            $table->dropForeign(['executor_id']);
            $table->dropColumn('executor_id');
        });

        Schema::table('social_workflows', function (Blueprint $table) {
            $table->foreignId('executor_id')->after('scheduled_person_id')->nullable()->constrained(
                table: 'organization_employees')->cascadeOnDelete();
        });
    }
};
