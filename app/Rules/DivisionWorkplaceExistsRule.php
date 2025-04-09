<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class DivisionWorkplaceExistsRule implements ValidationRule
{
    public int $basicContractId;

    public function __construct($basicContractId)
    {
        $this->basicContractId = $basicContractId;

    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (DB::table('contract_contract_workplaces')->where(['basic_contract_id' => $this->basicContractId, 'division_id' => $value])->exists()) {
            $fail(__('validation.existed', ['attribute' => __('attributes.contract_workplace.division_id')]));
        }
    }
}
