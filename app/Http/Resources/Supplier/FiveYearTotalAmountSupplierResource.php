<?php

namespace App\Http\Resources\Supplier;

use App\Enums\Workflow\ExecutionPaymentEnum;
use App\Enums\Workflow\WorkflowOrderEnum;
use App\Models\Product;
use App\Models\SocialData;
use App\Models\Supplier;
use App\Models\Workflow;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * @mixin Supplier
 */
class FiveYearTotalAmountSupplierResource extends JsonResource
{
    protected function socialDataCountByYear(Collection $socialDataCollection, int $year): array
    {
        $totalAmount = $socialDataCollection->filter(function (SocialData $item) use ($year) {
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

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $socialData = $this->products->flatMap(function (Product $item) {
            return $item->socialData;
        });

        $currentYear = Carbon::now()->year;

        // Collect last 5 years
        $years = collect(range($currentYear - 4, $currentYear));

        return [
            'id' => $this->id,
            'sales_store_id' => $this->sales_store_id,
            'supplier_classification' => $this->supplier_classification,
            'use_classification' => $this->use_classification,
            'social_data_count' => $years->map(fn(int $year) => $this->socialDataCountByYear($socialData, $year)),
        ];
    }
}
