<?php

namespace App\Http\Resources\Supplier;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Helpers\DisplayHelper;
use App\Http\Resources\Company\SiteItemByCompanyResource;
use App\Http\Resources\Employee\EmployeeRelatedResource;
use App\Http\Resources\Site\SiteSupplierResource;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Supplier
 */
class SupplierItemResource extends JsonResource
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
            'supplier_classification' => $this->supplier_classification,
            'supplier_person_id' => $this->supplier_person_id,
            'supplier_person' => $this->whenLoaded('supplierPerson', fn() => EmployeeRelatedResource::make($this->supplierPerson)),
            'my_company_person_id' => $this->my_company_person_id,
            'my_company_person' => $this->whenLoaded('myCompanyPerson', fn() => EmployeeRelatedResource::make($this->myCompanyPerson)),
            'display_order' => $this->display_order,
            'use_classification' => $this->use_classification,
            'updated_at' => $this->updated_at ? Carbon::parse($this->updated_at)->format(DateTimeEnum::DATE_FORMAT) : null
        ];
    }
}
