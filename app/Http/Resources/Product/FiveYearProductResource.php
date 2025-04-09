<?php

namespace App\Http\Resources\Product;

use App\Enums\Workflow\ExecutionPaymentEnum;
use App\Enums\Workflow\WorkflowOrderEnum;
use App\Models\Product;
use App\Models\SocialData;
use App\Models\Workflow;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Product
 */
class FiveYearProductResource extends JsonResource
{
    protected function socialDataCountByYear(int $year): array
    {
        $count = $this->relationLoaded('socialData') ? $this->socialData->filter(function (SocialData $item) use ($year) {
            return $item->relationLoaded('workflows') && $item->workflows->contains(function (Workflow $workflow) use ($year) {
                    return $workflow->workflow_order == WorkflowOrderEnum::PAYMENT &&
                        $workflow->execution_type == ExecutionPaymentEnum::PAID &&
                        Carbon::parse($workflow->execution_at)->year == $year;
                });
        })->count() : 0;
        return [
            'year' => $year,
            'count' => $count,
        ];
    }

    public function toArray(Request $request): array
    {
        $currentYear = Carbon::now()->year;

        // Collect last 3 years
        $years = collect(range($currentYear - 4, $currentYear));

        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'supplier_id' => $this->supplier_id,
            'social_data_count' => $years->map(fn(int $year) => $this->socialDataCountByYear($year)),
        ];
    }
}
