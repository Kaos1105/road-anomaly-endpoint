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
        Schema::create('social_customer_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained(
                table: 'social_management_groups'
            )->cascadeOnDelete();
            $table->string('name', 100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_customer_categories');
    }
};
