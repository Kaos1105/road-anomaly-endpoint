<?php

namespace App\Http\Resources\Employee;

use App\Enums\Common\DateTimeEnum;
use App\Enums\Common\FavoriteFlagEnum;
use App\Helpers\DateTimeHelper;
use App\Helpers\DisplayHelper;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Employee
 */
class EmployeeDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        $age = null;
        if ($this->day_of_birth) {
            $birthDate = Carbon::parse($this->day_of_birth);
            if ($this->day_of_death) {
                $dayForAge = Carbon::parse($this->day_of_death);
            } else {
                $dayForAge = Carbon::now();
            }
            $age = floor($birthDate->diffInYears($dayForAge));
        }

        return [
            'id' => $this->id,
            'has_favorite' => count($this->employeeFavorites) > 0 ? FavoriteFlagEnum::FAVORITE : FavoriteFlagEnum::NO_FAVORITE,
            'code' => $this->code,
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'kana' => $this->kana,
            'day_of_birth' => DateTimeHelper::formatDateTime($this->day_of_birth, DateTimeEnum::DATE_FORMAT),
            'day_of_death' => DateTimeHelper::formatDateTime($this->day_of_death, DateTimeEnum::DATE_FORMAT),
            'age' => $age,
            'period_accuracy_flg' => $this->period_accuracy_flg,
            'maiden_name' => $this->maiden_name,
            'previous_name_flg' => $this->previous_name_flg,
            'gender' => $this->gender,
            'employees_classification' => $this->employees_classification,
            'en_notation' => $this->en_notation,
            'company_email' => $this->company_email,
            'company_phone' => $this->company_phone,
            'post_code' => $this->post_code,
            'address_1' => $this->address_1,
            'address_2' => $this->address_2,
            'address_3' => $this->address_3,
            'phone' => $this->phone,
            'email' => $this->email,
            'memo' => $this->memo,
            'display_order' => $this->display_order,
            'use_classification' => $this->use_classification,
            'biography' => $this->biography,
            'update_history' => $this->update_history,
            'transfer_id' => $this->whenLoaded('transfers', fn() => $this->transfers?->first()?->id),
            'created_info' => $this->whenLoaded('createdBy', fn() => [
                'date' => DateTimeHelper::formatDateTime($this->created_at, DateTimeEnum::DATE_TIME_FORMAT),
                'name' => DisplayHelper::formatEmployeeName($this->createdBy),
            ]),
            'updated_info' => $this->whenLoaded('updatedBy', fn() => [
                'date' => DateTimeHelper::formatDateTime($this->updated_at, DateTimeEnum::DATE_TIME_FORMAT),
                'name' => DisplayHelper::formatEmployeeName($this->updatedBy),
            ]),
        ];
    }
}
