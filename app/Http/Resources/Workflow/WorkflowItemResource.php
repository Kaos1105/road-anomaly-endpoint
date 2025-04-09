<?php

namespace App\Http\Resources\Workflow;

use App\Enums\Common\DateTimeEnum;
use App\Enums\Workflow\WorkflowOrderEnum;
use App\Helpers\DateTimeHelper;
use App\Http\Resources\Employee\EmployeeNameResource;
use App\Models\SocialEvent;
use App\Models\Workflow;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transform the resource into an array.
 *
 * @mixin   Workflow
 */
class WorkflowItemResource extends JsonResource
{
    protected SocialEvent|null $socialEvent;

    public function toArray(Request $request): array
    {
        $deadline = null;
        if ($this->socialEvent !== null) {
            $deadline = match ($this->workflow_order) {
                WorkflowOrderEnum::DRAFTING => $this->socialEvent->creation_deadline,
                WorkflowOrderEnum::DECISION => $this->socialEvent->approval_deadline,
                WorkflowOrderEnum::ORDER => $this->socialEvent->order_deadline,
                default => null,
            };
        }
        return [
            'id' => $this->id,
            'social_data_id' => $this->social_data_id,
            'workflow_order' => $this->workflow_order,
            'scheduled_person_id' => $this->scheduled_person_id,
            'scheduled_person' => $this->whenLoaded('scheduledPerson',
                fn() => EmployeeNameResource::make($this->scheduledPerson)),
            'executor_id' => $this->executor_id,
            'executor' => $this->whenLoaded('executor',
                fn() => EmployeeNameResource::make($this->executor)),
            'execution_type' => $this->execution_type,
            'execution_at' => DateTimeHelper::formatDateTime($this->execution_at, DateTimeEnum::DATE_FORMAT),
            'deadline' => DateTimeHelper::formatDateTime($deadline, DateTimeEnum::DATE_FORMAT),
        ];
    }

    public function setParams(SocialEvent $socialEvent): self
    {
        $this->socialEvent = $socialEvent;
        return $this;
    }
}
