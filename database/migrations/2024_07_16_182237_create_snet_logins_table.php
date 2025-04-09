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
        Schema::create('snet_logins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained(
                table: 'organization_employees'
            )->cascadeOnDelete();
            $table->string('login_id', 100);
            $table->string('password', 100);
            $table->text('memo')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('snet_logins');
    }
};
