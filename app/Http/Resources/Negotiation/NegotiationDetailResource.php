<?php

namespace App\Http\Resources\Negotiation;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Helpers\DisplayHelper;
use App\Http\DTO\Negotiation\NegotiableData;
use App\Http\Resources\ClientSite\ClientSiteDropdownResource;
use App\Models\Negotiation;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Negotiation
 */
class NegotiationDetailResource extends JsonResource
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
            'client_site_id' => $this->client_site_id,
            'client_site' => $this->whenLoaded('clientSite', fn() => ClientSiteDropdownResource::make($this->clientSite)),
            'like_counter' => $this->like_counter ?: 0,
            'date_time' => DateTimeHelper::formatDateTime($this->date_time, DateTimeEnum::DATE_TIME_FORMAT_WO_SECOND),
            'progress_classification' => $this->progress_classification,
            'purpose' => $this->purpose,
            'result' => $this->result,
            'manager_comment' => $this->manager_comment,
            'created_info' => $this->whenLoaded('createdBy', fn() => [
                'date' => DateTimeHelper::formatDateTime($this->created_at, DateTimeEnum::DATE_TIME_FORMAT),
                'name' => DisplayHelper::formatEmployeeName($this->createdBy),
            ]),
            'updated_info' => $this->whenLoaded('updatedBy', fn() => [
                'date' => DateTimeHelper::formatDateTime($this->updated_at, DateTimeEnum::DATE_TIME_FORMAT),
                'name' => DisplayHelper::formatEmployeeName($this->updatedBy),
            ]),
            'comment_updated_info' => $this->whenLoaded('commentBy', fn() => [
                'date' => DateTimeHelper::formatDateTime($this->manager_comment_at, DateTimeEnum::DATE_TIME_FORMAT),
                'name' => DisplayHelper::formatEmployeeName($this->commentBy),
            ]),
            'client_employees' => $employees?->clientEmployees,
            'my_company_employees' => $employees?->myCompanyEmployees,
        ];
    }
}
