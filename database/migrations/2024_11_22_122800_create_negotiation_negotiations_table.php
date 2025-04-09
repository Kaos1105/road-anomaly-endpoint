<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\Negotiation\ProgressClassificationEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('negotiation_negotiations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_site_id')->constrained(
                table: 'negotiation_client_sites'
            )->cascadeOnDelete();
            $table->dateTime('date_time');
            $table->integer('progress_classification')->unsigned()->default(ProgressClassificationEnum::NOT_YET);
            $table->text('purpose')->nullable();
            $table->text('result')->nullable();
            $table->text('manager_comment')->nullable();
            $table->integer('like_counter')->unsigned()->nullable();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->bigInteger('management_comment_by')->unsigned()->nullable();
            $table->timestamp('management_comment_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('negotiation_negotiations');
    }
};
