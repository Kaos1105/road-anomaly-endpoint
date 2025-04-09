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
        Schema::create('negotiation_management_department_employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('management_department_id')->constrained(
                table: 'negotiation_management_departments',
                indexName: 'negotiation_management_department_employee_fk'
            )->cascadeOnDelete();
            $table->foreignId('my_company_employee_id')->constrained(
                table: 'negotiation_my_company_employees',
                indexName: 'negotiation_management_department_my_employee_fk'
            )->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('negotiation_management_department_employees');
    }
};
