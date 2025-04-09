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
        Schema::create('negotiation_negotiation_employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('negotiation_id')->constrained(
                table: 'negotiation_negotiations',
                indexName: 'negotiation_employee_fk'
            )->cascadeOnDelete();
            $table->morphs('negotiable', 'negotiable_type_negotiable_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('negotiation_negotiation_employees');
    }
};
