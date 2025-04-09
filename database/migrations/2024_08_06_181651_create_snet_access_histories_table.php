<?php

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
        Schema::create('snet_access_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained(table: 'organization_employees')->cascadeOnDelete();
            $table->foreignId('system_id')->constrained(table: 'snet_systems')->cascadeOnDelete();
            $table->string('action', 50);
            $table->nullableMorphs('accessible');
            $table->string('message', 200)->nullable();
            $table->datetime('access_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('snet_access_histories');
    }
};
