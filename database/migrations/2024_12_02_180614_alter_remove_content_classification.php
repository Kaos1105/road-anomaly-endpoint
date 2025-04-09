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
        Schema::table('snet_chat_contents', function (Blueprint $table) {
           $table->dropColumn('content_classification');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('snet_chat_contents', function (Blueprint $table) {
            $table->tinyInteger('content_classification');
        });
    }
};
