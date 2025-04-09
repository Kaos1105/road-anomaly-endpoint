<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\SocialCustomer\AddressPrintingClassificationEnum;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('social_customers', function (Blueprint $table) {
            $table->boolean('address_printing_7')->default(AddressPrintingClassificationEnum::TRUE)->after('address_printing_6');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('social_customers', function (Blueprint $table) {
            $table->dropColumn('address_printing_7');
        });
    }
};
