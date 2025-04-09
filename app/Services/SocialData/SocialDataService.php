<?php

namespace App\Services\SocialData;

use App\Enums\Common\DateTimeEnum;
use App\Enums\Product\TaxRateEnum;
use App\Enums\Workflow\ExecutionDraftEnum;
use App\Enums\Workflow\ExecutionEndEnum;
use App\Enums\Workflow\ExecutionOrderEnum;
use App\Enums\Workflow\ExecutionPaymentEnum;
use App\Enums\Workflow\ExecutionReceiptEnum;
use App\Enums\Workflow\WorkflowOrderEnum;
use App\Helpers\DateTimeHelper;
use App\Helpers\SocialDataHelper;
use App\Http\DTO\SocialData\RegisSocialData;
use App\Http\DTO\SocialData\UpdateProgressSocialData;
use App\Models\Customer;
use App\Models\SocialData;
use App\Models\SocialEvent;
use App\Models\Workflow;
use App\Repositories\Customer\ICustomerRepository;
use App\Repositories\SocialData\ISocialDataRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SocialDataService implements ISocialDataService
{
    public function __construct(
        public ISocialDataRepository $socialDataRepository,
        public ICustomerRepository   $customerRepository,
    )
    {
    }

    public function getRepo(): ISocialDataRepository
    {
        return $this->socialDataRepository;
    }

    public function getChildNames(SocialData $data): ?string
    {
        return null;
    }

    private function createSocialDataWorkflows(SocialEvent $socialEvent, Customer $customer): Collection
    {
        $workflows = collect();
        foreach (WorkflowOrderEnum::getValues() as $workflowOrder) {
            if ($workflowOrder != WorkflowOrderEnum::CREATE) {
                $scheduledPersonId = match ($workflowOrder) {
                    WorkflowOrderEnum::PREPARE => $socialEvent->managementGroup->preparatory_personnel_id,
                    WorkflowOrderEnum::RECEIPT, WorkflowOrderEnum::DRAFTING => $customer->responsible_id,
                    WorkflowOrderEnum::APPLY => $socialEvent->managementGroup->applicant_id,
                    WorkflowOrderEnum::APPROVED => $socialEvent->managementGroup->approver_id,
                    WorkflowOrderEnum::DECISION => $socialEvent->managementGroup->final_decision_maker_id,
                    WorkflowOrderEnum::ORDER => $socialEvent->managementGroup->ordering_personnel_id,
                    WorkflowOrderEnum::PAYMENT => $socialEvent->managementGroup->payment_personnel_id,
                    WorkflowOrderEnum::FINISH => $socialEvent->managementGroup->completion_personnel_id,
                    default => null,
                };

                $workflows->push([
                    'workflow_order' => $workflowOrder,
                    'scheduled_person_id' => $scheduledPersonId,
                    'execution_type' => ExecutionDraftEnum::UNPROCESS
                ]);
            }
        }
        return $workflows;
    }

    private function mapInputToSocialData(Collection $customers, Collection $inputSocialData, SocialEvent $socialEvent): Collection
    {
        $result = collect();
        $socialEvent->load(['managementGroup']);
        $employee = \Auth::user()->employee;
        $commentHistory = Carbon::now()->format(DateTimeEnum::DATE_FORMAT)
            . ' ' . "{$employee->last_name}　{$employee->first_name}" . trans('attributes.social_data.comment_history_suffix');

        $inputSocialData->each(function (RegisSocialData $socialDataInput) use (
            $customers, $socialEvent, $result,
            $commentHistory, $employee
        ) {
            /**
             * @var Customer $customer
             */
            $customer = $customers->first(function (Customer $customer) use ($socialDataInput) {
                return $customer->id == $socialDataInput->customerId;
            });
            $previousSocialData = $customer->socialData->first(function (SocialData $socialData) use ($socialDataInput) {
                return $socialData->id == $socialDataInput->previousSocialDataId;
            });
            $insertingData = SocialData::make([
                'social_event_id' => $socialEvent->id,
                'customer_id' => $customer->id,
                'display_transfer_id' => $customer->display_transfer_id,
                'product_id' => $previousSocialData?->product_id,
                'product_name' => $previousSocialData?->product_name,
                'unit_price' => $previousSocialData?->unit_price,
                'discount' => $previousSocialData?->discount,
                'tax_classification_1' => $previousSocialData?->tax_classification_1 ?? TaxRateEnum::TEN_PERCENT,
                'tax_1' => $previousSocialData?->tax_1,
                'shipping_cost' => $previousSocialData?->shipping_cost,
                'tax_classification_2' => $previousSocialData?->tax_classification_2 ?? TaxRateEnum::TEN_PERCENT,
                'tax_2' => $previousSocialData?->tax_2,
                'other' => $previousSocialData?->other,
                'tax_classification_3' => $previousSocialData?->tax_classification_3 ?? TaxRateEnum::TEN_PERCENT,
                'total_amount' => $previousSocialData?->total_amount,
                'total_tax' => $previousSocialData?->total_tax,
                'processing_site' => $previousSocialData?->processing_site ?? $customer->processing_site,
                'accounting_company' => $previousSocialData?->accounting_company ?? $customer->accounting_company,
                'accounting_department_id' => $previousSocialData?->accounting_department_id ?? $customer->accounting_department_id,
                'address_classification' => $previousSocialData?->address_classification ?? $customer->address_classification,
                'comment_history' => $commentHistory,
                'updated_by' => $employee->id,
                'created_by' => $employee->id,
            ]);

            DB::transaction(function () use ($insertingData, $socialEvent, $customer) {
                $insertingData->save();
                $insertingData->workflows()->createMany($this->createSocialDataWorkflows($socialEvent, $customer));
            });
            $insertingData->load(['displayTransfer.employee']);

            $result->push($insertingData);
        }
        );

        return $result;
    }

    public function regisSocialData(SocialEvent $socialEvent, Collection $insertingSocialData): Collection
    {
        $customerIds = $insertingSocialData->map(function (RegisSocialData $regisSocialData) {
            return $regisSocialData->customerId;
        })->toArray();
        $customers = $this->customerRepository->getRegisteringCustomerSocialData($socialEvent, $customerIds);
        return $this->mapInputToSocialData($customers, $insertingSocialData, $socialEvent);
    }

    public function updateProgress(UpdateProgressSocialData $attributes, SocialData $socialData): SocialData
    {
        $socialData->load('workflows');
        $now = Carbon::now()->format(DateTimeEnum::DATE_FORMAT);
        $loginEmployee = \Auth::user()->employee;
        $comment = $attributes->comment ? $attributes->comment . "\n" : "";
        $timeStamp = "$now $loginEmployee->last_name" . '　' . "$loginEmployee->first_name";

        $workflowData = SocialDataHelper::buildWorkflowData($loginEmployee, $attributes);
        $socialDataAttributes = SocialDataHelper::buildSocialDataAttributes($loginEmployee, $attributes);

        if ($attributes->executionType === ExecutionEndEnum::COMPLETED) {
            $attributes->dataProgress !== WorkflowOrderEnum::FINISH && $socialDataAttributes['data_progress'] += 10;
            $socialDataAttributes['comment_history'] = SocialDataHelper::commentHistoryForCompleteProgress($socialDataAttributes['data_progress'], $comment, $timeStamp, $socialData);

            $socialData->update($socialDataAttributes);
            $socialData->workflows()->where('workflow_order', $socialDataAttributes['data_progress'])->update($workflowData);

        } else if ($attributes->executionType === ExecutionEndEnum::UNPROCESS) {
            $workflowData['executor_id'] = null;
            $workflowData['execution_at'] = null;
            $socialData->workflows()->where('workflow_order', $socialDataAttributes['data_progress'])->update($workflowData);

            $latestNonPendingWorkflow = $this->getRepo()->getLatestNonPendingWorkflow($socialData);
            $socialDataAttributes['data_progress'] = $latestNonPendingWorkflow !== null ?
                $latestNonPendingWorkflow->workflow_order : WorkflowOrderEnum::CREATE;
            $socialDataAttributes['comment_history'] = SocialDataHelper::updateCommentHistory($comment, $timeStamp, "さんが、差戻しました。\n", $socialData);

            $socialData->update($socialDataAttributes);

        } else if ($attributes->executionType === ExecutionOrderEnum::NOT_ORDER
            || $attributes->executionType === ExecutionReceiptEnum::REJECTED || $attributes->executionType === ExecutionPaymentEnum::NOT_PAID) {
            $attributes->dataProgress != WorkflowOrderEnum::FINISH && $socialDataAttributes['data_progress'] += 10;
            $socialDataAttributes['comment_history'] = SocialDataHelper::commentHistoryForRejectProgress($socialDataAttributes['data_progress'], $comment, $timeStamp, $socialData);

            $socialData->update($socialDataAttributes);
            $socialData->workflows()->where('workflow_order', $socialDataAttributes['data_progress'])->update($workflowData);

        } else if ($attributes->executionType === ExecutionReceiptEnum::CANCELLED && $attributes->dataProgress == WorkflowOrderEnum::ORDER) {
            $attributes->dataProgress != WorkflowOrderEnum::FINISH && $socialDataAttributes['data_progress'] += 10;
            $socialDataAttributes['comment_history'] = SocialDataHelper::updateCommentHistory($comment, $timeStamp, "さんが、取り消しました。\n", $socialData);

            $socialData->update($socialDataAttributes);
            $socialData->workflows()->where('workflow_order', $socialDataAttributes['data_progress'])->update($workflowData);
        }
        return $socialData;
    }

    public function getDeleteError(SocialData $socialData): ?string
    {
        if ($socialData->data_progress > WorkflowOrderEnum::APPLY) {

            return __('errors.social_data_cant_delete');
        }
        return null;
    }

    public function getOrderedDateDropdown(SocialEvent $socialEvent): Collection
    {
        return $this->socialDataRepository->getSocialEventOrderedDate($socialEvent)->unique(function (Workflow $workflow) {
            return DateTimeHelper::formatDateTime($workflow->execution_at, DateTimeEnum::DATE_FORMAT);
        });
    }
}
