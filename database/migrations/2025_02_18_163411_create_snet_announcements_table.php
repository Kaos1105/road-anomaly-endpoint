<?php

use App\Enums\Announcement\AnnouncementClassificationEnum;
use App\Enums\Common\UseFlagEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('snet_announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('system_id')->constrained(
                table: 'snet_systems'
            )->cascadeOnDelete();
            $table->foreignId('display_id')->nullable()->constrained(
                table: 'snet_displays')->cascadeOnDelete();
            $table->tinyInteger('announcement_classification')->unsigned()->default(AnnouncementClassificationEnum::INFORMATION);
            $table->string('title', 100);
            $table->text('content')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->tinyInteger('use_classification')->unsigned()->default(UseFlagEnum::USE);
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
        Schema::dropIfExists('snet_announcements');
    }
};
