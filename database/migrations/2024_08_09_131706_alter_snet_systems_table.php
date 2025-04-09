<?php

use App\Enums\System\OperationFlagEnum;
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
        Schema::table('snet_systems', function (Blueprint $table) {
            $table->dropColumn('operation_classification');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('snet_systems', function (Blueprint $table) {
            $table->tinyInteger('operation_classification')->unsigned()->default(OperationFlagEnum::STOP);
        });
    }
};
