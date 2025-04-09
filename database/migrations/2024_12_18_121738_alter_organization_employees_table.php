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
        Schema::table('organization_employees', function (Blueprint $table) {
            $table->text('update_history')->after('use_classification')->nullable();
            $table->text('biography')->after('use_classification')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organization_employees', function (Blueprint $table) {
            $table->dropColumn('update_history');
            $table->dropColumn('biography');
        });
    }
};
