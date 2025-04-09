<?php

namespace App\Helpers;

use App\Enums\SocialCustomer\AddressClassificationEnum;
use App\Enums\SocialEvent\EventProgressClassificationEnum;
use App\Enums\Workflow\WorkflowOrderEnum;
use App\Http\DTO\SocialData\UpdateProgressSocialData;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\SocialData;
use App\Models\SocialEvent;
use App\Models\Workflow;
use Carbon\Carbon;

class SocialDataHelper
{
    /**
     * @param Employee $loginEmployee
     * @param UpdateProgressSocialData $attributes
     * @return array{'executor_id': int, 'execution_type': int, 'execution_at': Carbon}
     */
    public static function buildWorkflowData(Employee $loginEmployee, UpdateProgressSocialData $attributes): array
    {
        return [
            'executor_id' => $loginEmployee->id,
            'execution_type' => $attributes->executionType,
            'execution_at' => Carbon::now(),
        ];
    }

    /**
     * @param Employee $loginEmployee
     * @param UpdateProgressSocialData $attributes
     * @return array{'comment_history': string, 'data_progress': int, 'updated_by': int}
     */
    public static function buildSocialDataAttributes(Employee $loginEmployee, UpdateProgressSocialData $attributes): array
    {
        return [
            ...$attributes->toArray(),
            'comment_history' => '',
            'data_progress' => $attributes->dataProgress,
            'updated_by' => $loginEmployee->id,
        ];
    }

    public static function updateCommentHistory(string $comment, string $timeStamp, string $actionText, SocialData $socialData,): string
    {
        return $comment . $timeStamp . $actionText . $socialData->comment_history;
    }

    public static function commentHistoryForCompleteProgress(int $dataProgress, string $comment, string $timeStamp, SocialData $socialData): string
    {
        return match ($dataProgress) {
            WorkflowOrderEnum::PREPARE => SocialDataHelper::updateCommentHistory($comment, $timeStamp, "さんが、準備しました。\n", $socialData),
            WorkflowOrderEnum::DRAFTING => SocialDataHelper::updateCommentHistory($comment, $timeStamp, "さんが、起案しました。\n", $socialData),
            WorkflowOrderEnum::APPLY => SocialDataHelper::updateCommentHistory($comment, $timeStamp, "さんが、申請しました。\n", $socialData),
            WorkflowOrderEnum::APPROVED => SocialDataHelper::updateCommentHistory($comment, $timeStamp, "さんが、承認しました。\n", $socialData),
            WorkflowOrderEnum::DECISION => SocialDataHelper::updateCommentHistory($comment, $timeStamp, "さんが、決裁しました。\n", $socialData),
            WorkflowOrderEnum::ORDER => SocialDataHelper::updateCommentHistory($comment, $timeStamp, "さんが、発注しました。\n", $socialData),
            WorkflowOrderEnum::RECEIPT => SocialDataHelper::updateCommentHistory($comment, $timeStamp, "さんが、受取確認しました。\n", $socialData),
            WorkflowOrderEnum::PAYMENT => SocialDataHelper::updateCommentHistory($comment, $timeStamp, "さんが、支払しました。\n", $socialData),
            WorkflowOrderEnum::FINISH => SocialDataHelper::updateCommentHistory($comment, $timeStamp, "さんが、終了しました。\n", $socialData),
            default => $socialData->comment_history,
        };
    }

    public static function commentHistoryForRejectProgress(int $dataProgress, string $comment, string $timeStamp, SocialData $socialData): string
    {
        return match ($dataProgress) {
            WorkflowOrderEnum::ORDER => $comment . $timeStamp . "さんが、発注しませんでした。\n" . $socialData->comment_history,
            WorkflowOrderEnum::RECEIPT => $comment . $timeStamp . "さんが、先方が受取辞退したことを確認しました。\n" . $socialData->comment_history,
            WorkflowOrderEnum::PAYMENT => $comment . $timeStamp . "さんが、支払しませんでした。\n" . $socialData->comment_history,
            default => $socialData->comment_history,
        };
    }

    /**
     * @param SocialData $socialData
     * @param SocialEvent|null $socialEvent
     * @return array{'isEnabledBtnEdit': bool, 'isEnabledBtnWorkflow': bool}
     */
    public static function socialDataBtnFLg(SocialData $socialData, SocialEvent $socialEvent = null): array
    {

        $isEnabledBtnEdit = false;
        $isEnabledBtnWorkflow = false;

        if ($socialData->data_progress <= WorkflowOrderEnum::DRAFTING) {
            $isEnabledBtnEdit = $socialData->workflows->filter(function (Workflow $workflow) {
                return $workflow->workflow_order <= WorkflowOrderEnum::DRAFTING;
            })->contains(function (Workflow $workflow) {
                return $workflow->scheduled_person_id == \Auth::user()->employee_id;
            });
        }
        $isEnabledBtnEdit = $isEnabledBtnEdit && (!$socialEvent || $socialEvent->event_progress !== EventProgressClassificationEnum::COMPLETED);

        $currentWorkflow = $socialData->workflows->filter(function (Workflow $workflow) use ($socialData) {
            return $socialData->data_progress == $workflow->workflow_order;
        })->first();

        if ($socialData->data_progress == WorkflowOrderEnum::FINISH) {
            $isEnabledBtnWorkflow = ($currentWorkflow?->scheduled_person_id == \Auth::user()->employee_id);
        } else {
            $nextWorkflow = $socialData->workflows->filter(function (Workflow $workflow) use ($socialData) {
                return ($socialData->data_progress + 10) == $workflow->workflow_order;
            })->first();
            $isEnabledBtnWorkflow = ($nextWorkflow?->scheduled_person_id == \Auth::user()->employee_id);
        }
        $isEnabledBtnWorkflow = $isEnabledBtnWorkflow && (!$socialEvent || $socialEvent->event_progress !== EventProgressClassificationEnum::COMPLETED);

        return [$isEnabledBtnEdit, $isEnabledBtnWorkflow];
    }

    public static function getShippingInfo(SocialData $socialData, Customer $customer): array
    {
        $employee = $socialData->relationLoaded('displayTransfer') && $socialData->displayTransfer?->relationLoaded('employee')
            ? $socialData->displayTransfer->employee : null;
        $site = $socialData->relationLoaded('displayTransfer') && $socialData->displayTransfer?->relationLoaded('site')
            ? $socialData->displayTransfer->site : null;

        return match ($socialData->address_classification) {
            AddressClassificationEnum::HOME => [
                'post_code' => $employee?->post_code,
                'address_1' => $employee?->address_1,
                'address_2' => $employee?->address_2,
                'address_3' => $employee?->address_3,
                'phone' => $employee?->phone,
            ],
            AddressClassificationEnum::COMPANY => [
                'post_code' => $site?->post_code,
                'address_1' => $site?->address_1,
                'address_2' => $site?->address_2,
                'address_3' => $site?->address_3,
                'phone' => $site?->phone,
            ],
            AddressClassificationEnum::DESIGNATION => [
                'post_code' => $customer->specified_post_code,
                'address_1' => $customer->specified_address_1,
                'address_2' => $customer->specified_address_2,
                'address_3' => $customer->specified_address_3,
                'phone' => $customer->specified_phone,
            ],
            default => [
                'post_code' => null,
                'address_1' => null,
                'address_2' => null,
                'address_3' => null,
                'phone' => null,
            ],
        };
    }
}
