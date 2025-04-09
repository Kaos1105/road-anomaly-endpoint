<?php

use App\Enums\AccessPermission\Permission1FlagEnum;
use App\Enums\AccessPermission\Permission2FlagEnum;
use App\Enums\AccessPermission\Permission3FlagEnum;
use App\Enums\AccessPermission\Permission4FlagEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('snet_access_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained(table: 'organization_employees')->cascadeOnDelete();
            $table->foreignId('system_id')->constrained(table: 'snet_systems')->cascadeOnDelete();
            $table->tinyInteger('permission_1')->unsigned()->default(Permission1FlagEnum::UN_AUTHORIZED_USER);
            $table->tinyInteger('permission_2')->unsigned()->default(Permission2FlagEnum::DATA_VIEWING);
            $table->tinyInteger('permission_3')->unsigned()->default(Permission3FlagEnum::GENERAL_INFORMATION);
            $table->tinyInteger('permission_4')->unsigned()->default(Permission4FlagEnum::AFFILIATED_DIVISION);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('memo')->nullable();
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
        Schema::dropIfExists('snet_access_permissions');
    }
};
