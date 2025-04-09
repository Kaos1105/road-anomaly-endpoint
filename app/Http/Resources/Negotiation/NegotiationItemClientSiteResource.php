<?php

namespace App\Http\Resources\Negotiation;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Http\DTO\Negotiation\NegotiableData;
use App\Models\Negotiation;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Negotiation
 */
class NegotiationItemClientSiteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        $employees = null;
        if (!empty($this->participants)) {
            $employees = NegotiableData::fromCollection($this->participants);
        }

        return [
            'id' => $this->id,
            'like_counter' => $this->like_counter,
            'date_time' => DateTimeHelper::formatDateTime($this->date_time, DateTimeEnum::DATE_TIME_FORMAT_WO_SECOND),
            'progress_classification' => $this->progress_classification,
            'result' => $this->result,
            'manager_comment' => $this->manager_comment,
            'updated_at' => DateTimeHelper::formatDateTime($this->updated_at, DateTimeEnum::DATE_FORMAT),
            'client_employees' => $employees?->clientEmployees,
            'my_company_employees' => $employees?->myCompanyEmployees,
        ];
    }
}
