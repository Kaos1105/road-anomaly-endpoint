<?php

use App\Enums\Contract\NotificationClassificationEnum;
use App\Enums\Contract\NotificationRangeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contract_user_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained(
                table: 'organization_employees'
            )->cascadeOnDelete();
            $table->tinyInteger('notification_classification')->unsigned()->default(NotificationClassificationEnum::NOTIFY);
            $table->tinyInteger('notification_range')->unsigned()->default(NotificationRangeEnum::ALL);
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract_user_settings');
    }
};
