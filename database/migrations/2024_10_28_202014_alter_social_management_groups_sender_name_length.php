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
        Schema::table('social_management_groups', function (Blueprint $table) {
            // Assuming the name of the foreign key constraint is social_workflows_executor_id_foreign
            $table->string('sender_name', 100)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('social_management_groups', function (Blueprint $table) {
            // Revert the 'sender_name' field length back to 20
            $table->string('sender_name', 20)->nullable()->change();
        });
    }
};
