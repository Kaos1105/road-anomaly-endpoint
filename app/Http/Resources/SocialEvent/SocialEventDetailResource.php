<?php

namespace App\Http\Resources\SocialEvent;

use App\Enums\Common\DateTimeEnum;
use App\Enums\SocialEvent\EventProgressClassificationEnum;
use App\Enums\Workflow\ExecutionDecisionEnum;
use App\Enums\Workflow\ExecutionDraftEnum;
use App\Enums\Workflow\ExecutionOrderEnum;
use App\Enums\Workflow\WorkflowOrderEnum;
use App\Helpers\DateTimeHelper;
use App\Helpers\DisplayHelper;
use App\Http\Resources\CustomerCategory\CustomerCategoryWithAggregationResource;
use App\Http\Resources\Employee\SocialResponsibleWithAggregationResource;
use App\Http\Resources\EventClassification\EventClassificationRelatedResource;
use App\Http\Resources\ManagementGroup\ManagementGroupRelatedResource;
use App\Models\CustomerCategory;
use App\Models\Employee;
use App\Models\SocialData;
use App\Models\SocialEvent;
use App\Models\Workflow;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * @mixin SocialEvent
 */
class SocialEventDetailResource extends JsonResource
{
    protected function getCustomerCategories(): Collection
    {
        $customerCategories = collect();
        if ($this->event_progress >= EventProgressClassificationEnum::UNDER_WAY && $this->relationLoaded('socialData')) {
            $this->socialData->each(function (SocialData $socialData) use (&$customerCategories) {
                $categoryContained = $customerCategories->contains(function (CustomerCategory $category) use ($socialData) {
                    return $category->name === $socialData->customer->category_name;
                });
                if (!$categoryContained) {
                    $customerCategories->push(CustomerCategory::make([
                        'name' => $socialData->customer->category_name,
                    ]));
                }
            });
        }
        return $customerCategories;
    }

    protected function getDrafters(): Collection
    {
        $responsibleEmployees = collect();
        if ($this->event_progress >= EventProgressClassificationEnum::UNDER_WAY && $this->relationLoaded('socialData')) {
            $this->socialData->each(function (SocialData $socialData) use (&$responsibleEmployees) {
                $employeeContained = $responsibleEmployees->contains(function (Employee $employee) use ($socialData) {
                    return $employee->id === $socialData->customer->responsible_id;
                });
                if (!$employeeContained) {
                    $responsibleEmployees->push($socialData->customer->responsibleEmployee);
                }
            });
        }
        return $responsibleEmployees;
    }

    protected function getDraftersWithTotal(): Collection
    {
        $drafters = $this->getDrafters()->map(
            fn(Employee $employee) => SocialResponsibleWithAggregationResource::make($employee)->setParams($this->resource));

        return $drafters->push([
            'id' => null,
            'code' => null,
            'last_name' => null,
            'first_name' => null,
            'maiden_name' => null,
            'previous_name_flg' => null,
            'use_classification' => null,
            'served_customer_count' => $drafters->sum(
                fn(SocialResponsibleWithAggregationResource $resource) => $resource->drafterSocialData->count()),
            'drafted_social_data_count' => $drafters->sum(
                fn(SocialResponsibleWithAggregationResource $resource) => $resource->draftedCount),
            'approved_social_data_count' => $drafters->sum(
                fn(SocialResponsibleWithAggregationResource $resource) => $resource->approvedCount),
            'decided_social_data_count' => $drafters->sum(
                fn(SocialResponsibleWithAggregationResource $resource) => $resource->decidedCount),
            'receipt_social_data_count' => $drafters->sum(
                fn(SocialResponsibleWithAggregationResource $resource) => $resource->receiptCount),
        ]);
    }

    protected function getCustomerCategoriesWithTotal(): Collection
    {
        $customerCategories =
            $this->getCustomerCategories()->map(
                fn(CustomerCategory $category) => CustomerCategoryWithAggregationResource::make($category)->setParams($this->resource));

        return $customerCategories->push([
            'name' => null,
            'number_of_payment' => $customerCategories->sum(
                fn(CustomerCategoryWithAggregationResource $resource) => $resource->paidWorkflows->count()),
            'amount_of_payment' => $customerCategories->sum(
                fn(CustomerCategoryWithAggregationResource $resource) => $resource->paidWorkflows->sum(
                    fn(SocialData $socialData) => $socialData->total_amount))
        ]);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $draftedWorkflows = collect();
        $decidedWorkflows = collect();
        $orderedWorkflows = collect();
        if ($this->relationLoaded('socialData')) {
            $this->socialData->each(function (SocialData $socialData) use ($draftedWorkflows, $decidedWorkflows, $orderedWorkflows) {
                if ($socialData->relationLoaded('workflows')) {
                    $socialData->workflows->each(function (Workflow $workflow) use ($draftedWorkflows, $decidedWorkflows, $orderedWorkflows) {
                        if ($workflow->workflow_order == WorkflowOrderEnum::DRAFTING && $workflow->execution_type == ExecutionDraftEnum::DRAFTED) {
                            $draftedWorkflows->push($workflow);
                        }
                        if ($workflow->workflow_order == WorkflowOrderEnum::DECISION && $workflow->execution_type == ExecutionDecisionEnum::DECIDED) {
                            $decidedWorkflows->push($workflow);
                        }
                        if ($workflow->workflow_order == WorkflowOrderEnum::ORDER && $workflow->execution_type == ExecutionOrderEnum::ORDERED) {
                            $orderedWorkflows->push($workflow);
                        }
                    });
                }
            });
        }

        return [
            'id' => $this->id,
            'event_id' => $this->event_id,
            'event_classification' => $this->whenLoaded('eventClassification', fn() => EventClassificationRelatedResource::make($this->eventClassification)),
            'group_id' => $this->group_id,
            'management_group' => $this->whenLoaded('managementGroup', fn() => ManagementGroupRelatedResource::make($this->managementGroup)),
            'event_title' => $this->event_title,
            'event_progress' => $this->event_progress,
            'planned_start' => DateTimeHelper::formatDateTime($this->planned_start, DateTimeEnum::DATE_FORMAT),
            'creation_deadline' => DateTimeHelper::formatDateTime($this->creation_deadline, DateTimeEnum::DATE_FORMAT),
            'approval_deadline' => DateTimeHelper::formatDateTime($this->approval_deadline, DateTimeEnum::DATE_FORMAT),
            'order_deadline' => DateTimeHelper::formatDateTime($this->order_deadline, DateTimeEnum::DATE_FORMAT),
            'planned_completion' => DateTimeHelper::formatDateTime($this->planned_completion, DateTimeEnum::DATE_FORMAT),
            'drafted_execution_at' => $draftedWorkflows->max(fn(Workflow $workflow) => DateTimeHelper::formatDateTime($workflow->execution_at, DateTimeEnum::DATE_FORMAT)),
            'approved_execution_at' => $decidedWorkflows->max(fn(Workflow $workflow) => DateTimeHelper::formatDateTime($workflow->execution_at, DateTimeEnum::DATE_FORMAT)),
            'ordered_execution_at' => $orderedWorkflows->max(fn(Workflow $workflow) => DateTimeHelper::formatDateTime($workflow->execution_at, DateTimeEnum::DATE_FORMAT)),
            'plan_comment' => $this->plan_comment,
            'actual_comment' => $this->actual_comment,
            'memo' => $this->memo,
            'use_classification' => $this->use_classification,
            'drafters' => $this->getDraftersWithTotal(),
            'customer_categories' => $this->getCustomerCategoriesWithTotal(),
            'created_info' => $this->whenLoaded('createdBy', fn() => [
                'date' => DateTimeHelper::formatDateTime($this->created_at, DateTimeEnum::DATE_TIME_FORMAT),
                'name' => DisplayHelper::formatEmployeeName($this->createdBy),
            ]),
            'updated_info' => $this->whenLoaded('updatedBy', fn() => [
                'date' => DateTimeHelper::formatDateTime($this->updated_at, DateTimeEnum::DATE_TIME_FORMAT),
                'name' => DisplayHelper::formatEmployeeName($this->updatedBy),
            ]),
            'is_enable_btn_flg' => [
                'purchase_order_btn' => $orderedWorkflows->count() > 0
            ]
        ];
    }
}
