<?php

use App\Enums\Common\UseFlagEnum;
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
        Schema::table('snet_displays', function (Blueprint $table) {
            $table->tinyInteger('use_classification')->unsigned()->default(UseFlagEnum::NOT_USE)->change();
        });

        Schema::table('snet_contents', function (Blueprint $table) {
            $table->tinyInteger('use_classification')->unsigned()->default(UseFlagEnum::NOT_USE)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('snet_displays', function (Blueprint $table) {
            $table->tinyInteger('use_classification')->unsigned()->default(UseFlagEnum::USE)->change();
        });

        Schema::table('snet_contents', function (Blueprint $table) {
            $table->tinyInteger('use_classification')->unsigned()->default(UseFlagEnum::USE)->change();
        });
    }
};
