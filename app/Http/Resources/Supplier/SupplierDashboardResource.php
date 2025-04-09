<?php

namespace App\Http\Resources\Supplier;

use App\Enums\Common\DateTimeEnum;
use App\Http\Resources\Employee\EmployeeRelatedResource;
use App\Http\Resources\Site\SiteSupplierResource;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Supplier
 */
class SupplierDashboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sales_store_id' => $this->sales_store_id,
            'sales_store' => $this->whenLoaded('salesStore', fn() => SiteSupplierResource::make($this->salesStore)),
        ];
    }
}
