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
        Schema::table('snet_logins', function(Blueprint $table) {
            $table->string('password_decrypt', 100)->after('password')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('snet_logins', function(Blueprint $table) {
            $table->dropColumn('password_decrypt');
        });
    }
};
