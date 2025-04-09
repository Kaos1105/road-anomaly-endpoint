<?php

namespace App\Http\Resources\System;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Models\System;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin System
 * @property int count_accessible_employees
 * @property int this_month_accessed_times
 * @property int this_year_accessed_times
 * @property int operation_classification
 * @property int this_year_accessed_help_times
 */
class SystemItemResource extends JsonResource
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
            'name' => $this->name,
            'operation_classification' => $this->operation_classification,
            'count_accessible_employees' => $this->count_accessible_employees,
            'this_month_accessed_times' => $this->this_month_accessed_times,
            'this_year_accessed_times' => $this->this_year_accessed_times,
            'this_year_accessed_help_times' => $this->this_year_accessed_help_times,
            'display_order' => $this->display_order,
            'start_date' => DateTimeHelper::formatDateTime($this->start_date, DateTimeEnum::DATE_FORMAT),
            'end_date' => DateTimeHelper::formatDateTime($this->end_date, DateTimeEnum::DATE_FORMAT),
            'updated_at' => DateTimeHelper::formatDateTime($this->updated_at, DateTimeEnum::DATE_FORMAT),
        ];
    }
}
