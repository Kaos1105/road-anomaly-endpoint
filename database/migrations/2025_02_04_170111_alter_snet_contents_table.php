<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\AccessPermission\Permission1FlagEnum;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('snet_contents', function (Blueprint $table) {
            $table->tinyInteger('permission_1')->unsigned()->after('name')->default(Permission1FlagEnum::SYSTEM_USER);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('snet_contents', function (Blueprint $table) {
            $table->dropColumn('permission_1');
        });
    }
};
