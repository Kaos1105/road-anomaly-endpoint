<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \App\Enums\AuthenticationHistory\AuthenticationFlagEnum;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('snet_logins', function (Blueprint $table) {
            $table->datetime('previous_login_at')->nullable()->after('password_decrypt');
            $table->tinyInteger('authen_flag')->unsigned()->nullable()->after('password_decrypt')->default(AuthenticationFlagEnum::IMPLEMENTED);
            $table->datetime('authen_at')->nullable()->after('password_decrypt');
            $table->datetime('password_updated_at')->nullable()->after('password_decrypt');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('snet_logins', function (Blueprint $table) {
            $table->dropColumn('password_updated_at');
            $table->dropColumn('authen_at');
            $table->dropColumn('authen_flag');
            $table->dropColumn('previous_login_at');
        });
    }
};
