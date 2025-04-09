<?php

declare(strict_types=1);

namespace App\Http\DTO\Facility;

use App\Http\Resources\CompanyCalendar\CompanyCalendarItemResource;
use App\Http\Resources\Facility\FacilityReservationPortalCollection;
use App\Http\Resources\FacilityUserSetting\FacilityUserSettingResource;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class FacilityPortalData extends Data
{
    public function __construct(
        public ?string                              $message = null,
        public ?bool                                $hasFacilityGroup = false,
        public ?bool                                $hasFacilities = false,
        public ?FacilityReservationPortalCollection $facilities = null,
        public ?FacilityUserSettingResource         $facilityUserSetting = null,
        public ?CompanyCalendarItemResource         $companyCalendar = null
    )
    {

    }

}
