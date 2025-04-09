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
        Schema::table('social_social_datas', function (Blueprint $table) {
            // Assuming the name of the foreign key constraint is social_workflows_executor_id_foreign
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');
        });

        // Re-add the foreign key constraint with on delete set to null
        Schema::table('social_social_datas', function (Blueprint $table) {
            $table->foreignId('product_id')->after('display_transfer_id')->nullable()->constrained(
                table: 'social_products')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('social_social_datas', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');
        });

        Schema::table('social_social_datas', function (Blueprint $table) {
            $table->foreignId('product_id')->after('display_transfer_id')->nullable()->constrained(
                table: 'social_products')->cascadeOnDelete();
        });
    }
};
