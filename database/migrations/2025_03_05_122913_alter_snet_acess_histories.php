<?php

use App\Enums\AccessHistory\ResultClassificationEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('snet_access_histories', function (Blueprint $table) {
            $table->string('result_classification', 50)->after('action')->nullable(false)->default(ResultClassificationEnum::OK);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('snet_access_histories', function (Blueprint $table) {
            $table->dropColumn('result_classification');
        });
    }
};
