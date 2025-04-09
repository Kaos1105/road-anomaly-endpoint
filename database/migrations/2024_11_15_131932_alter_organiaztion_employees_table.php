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
        Schema::table('organization_employees', function(Blueprint $table) {
            $table->string('phone', 20)->nullable()->change();
            $table->string('email', 100)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organization_employees', function(Blueprint $table) {
            $table->string('phone', 20)->nullable(false)->change();
            $table->string('email', 100)->nullable(false)->change();
        });
    }
};
