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
        Schema::table('negotiation_negotiations', function (Blueprint $table) {
            $table->renameColumn('management_comment_by', 'manager_comment_by');
            $table->renameColumn('management_comment_at', 'manager_comment_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('negotiation_negotiations', function (Blueprint $table) {
            $table->renameColumn('manager_comment_by', 'management_comment_by');
            $table->renameColumn('manager_comment_at', 'management_comment_at');
        });
    }
};
