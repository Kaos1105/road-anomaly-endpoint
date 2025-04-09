<?php

namespace App\Http\Resources\SocialData;

use App\Enums\Workflow\ExecutionPaymentEnum;
use App\Enums\Workflow\WorkflowOrderEnum;
use App\Models\SocialData;
use App\Models\Workflow;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * @mixin Collection
 */
class TopFiveYearDashboardResource extends JsonResource
{
//    /**
//     * Transform the resource into an array.
//     *
//     * @return array<string, mixed>
//     */
//    protected Collection|null $socialData;
//
//    public function setParams(Collection $socialData): self
//    {
//        $this->socialData = $socialData;
//        return $this;
//    }

    protected function socialDataCountByYear(int $year): array
    {
        $totalAmount = $this->resource->filter(function (SocialData $item) use ($year) {
            return $item->relationLoaded('workflows') && $item->workflows->contains(function (Workflow $workflow) use ($year) {
                    return $workflow->workflow_order == WorkflowOrderEnum::PAYMENT &&
                        $workflow->execution_type == ExecutionPaymentEnum::PAID &&
                        Carbon::parse($workflow->execution_at)->year == $year;
                });
        })->sum(fn(SocialData $socialData) => $socialData->total_amount);
        return [
            'year' => $year,
            'total_amount' => $totalAmount,
        ];
    }

    public function toArray(Request $request): array
    {
        $currentYear = Carbon::now()->year;

        // Collect last 5 years
        $years = collect(range($currentYear - 4, $currentYear));

        return [
            'social_data_count' => $years->map(fn(int $year) => $this->socialDataCountByYear($year)),
        ];
    }
}
