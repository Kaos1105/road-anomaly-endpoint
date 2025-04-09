<?php

namespace App\Http\Resources\Employee;

use App\Enums\Common\DateTimeEnum;
use App\Http\Resources\Transfer\EmployeeSelectTransferItemResource;
use App\Models\Employee;
use App\Models\Transfer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Employee
 */
class CustomerSelectEmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $transfers = EmployeeSelectTransferItemResource::make($this->transfers->first() ? $this->transfers->first() : Transfer::make([]));
        return [
            'id' => $this->id,
            'code' => $this->code,
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'maiden_name' => $this->maiden_name,
            'kana' => $this->kana,
            'address_1' => $this->address_1,
            'address_2' => $this->address_2,
            'address_3' => $this->address_3,
            'previous_name_flg' => $this->previous_name_flg,
            'use_classification' => $this->use_classification,
            'display_order' => $this->display_order,
            'updated_at' => $this->updated_at ? Carbon::parse($this->updated_at)->format(DateTimeEnum::DATE_TIME_FORMAT_WO_SECOND) : null,
            'transfer'=> $this->whenLoaded('transfers', fn () => EmployeeSelectTransferItemResource::make($this->transfers->first() ? $this->transfers->first() : Transfer::make([]))),
        ];
    }
}
