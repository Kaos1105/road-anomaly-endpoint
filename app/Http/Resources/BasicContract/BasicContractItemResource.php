<?php

namespace App\Http\Resources\BasicContract;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Http\Resources\Employee\EmployeeNameResource;
use App\Http\Resources\Site\SiteContractResource;
use App\Models\BasicContract;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin BasicContract
 */
class BasicContractItemResource extends JsonResource
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
            'code' => $this->code,
            'signing_at' => DateTimeHelper::formatDateTime($this->signing_at, DateTimeEnum::DATE_FORMAT),
            'counterparty' => $this->whenLoaded('counterparty', fn() => SiteContractResource::make($this->counterparty)),
            'counterparty_contractor' => $this->whenLoaded('counterpartyContractor', fn() => EmployeeNameResource::make($this->counterpartyContractor)),
            'counterparty_representative' => $this->whenLoaded('counterpartyRepresentative', fn() => EmployeeNameResource::make($this->counterpartyRepresentative)),
            'site' => $this->whenLoaded('site', fn() => SiteContractResource::make($this->site)),
            'contractor' => $this->whenLoaded('contractor', fn() => EmployeeNameResource::make($this->contractor)),
            'representative' => $this->whenLoaded('representative', fn() => EmployeeNameResource::make($this->representative)),
            'no' => $this->no,
            'name' => $this->name,
            'approval_flag' => $this->approval_flag,
            'display_order' => $this->display_order,
            'use_classification' => $this->use_classification,
            'updated_at' => DateTimeHelper::formatDateTime($this->updated_at, DateTimeEnum::DATE_FORMAT),
        ];
    }
}
