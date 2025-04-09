<?php

declare(strict_types=1);

namespace App\Http\DTO\Negotiation;

use App\Enums\AccessHistory\AccessibleTypeEnum;
use App\Http\Resources\ClientSite\ClientEmployee\ClientEmployeeDropdownResource;
use App\Http\Resources\ManagementDepartment\MyCompanyEmployee\MyCompanyEmployeeDropdownResource;
use App\Models\NegotiationEmployee;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class NegotiableData extends Data
{
    public function __construct(
        public ?Collection $clientEmployees,
        public ?Collection $myCompanyEmployees,
    )
    {

    }

    public static function fromCollection(Collection $negotiableCollection): self
    {
        $clientEmployees = collect();
        $myCompanyEmployees = collect();
        $negotiableCollection->each(function (NegotiationEmployee $item) use (&$clientEmployees, &$myCompanyEmployees) {
            if ($item->negotiable_type === AccessibleTypeEnum::CLIENT_EMPLOYEE && !empty($item->negotiable)) {
                $clientEmployees->push(ClientEmployeeDropdownResource::make($item->negotiable));
            }
            if ($item->negotiable_type === AccessibleTypeEnum::MY_COMPANY_EMPLOYEE && !empty($item->negotiable)) {
                $myCompanyEmployees->push(MyCompanyEmployeeDropdownResource::make($item->negotiable));
            }
        });
        return new NegotiableData($clientEmployees, $myCompanyEmployees);
    }
}
