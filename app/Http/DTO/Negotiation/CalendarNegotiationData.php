<?php

declare(strict_types=1);

namespace App\Http\DTO\Negotiation;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Http\DTO\SortingData;
use App\Http\Resources\Site\SiteSupplierResource;
use App\Models\Negotiation;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class CalendarNegotiationData extends Data
{
    public function __construct(
        public int                  $id,
        public string               $time,
        public int                  $progressClassification,
        public SiteSupplierResource $site,
        public Collection           $employees,
    )
    {

    }

    public static function fromCollection(Collection $negotiableCollection): Collection
    {
        return $negotiableCollection->map(function (Negotiation $negotiation) use (&$collection) {
            return CalendarNegotiationData::from([
                ...$negotiation->toArray(),
                'time' => DateTimeHelper::formatDateTime($negotiation->date_time, DateTimeEnum::TIME_FORMAT_V2),
                'site' => SiteSupplierResource::make($negotiation->site),
                'employees' => CalendarMyCompanyEmployeeData::fromCollection($negotiation->participants)
            ]);
        });
    }
}
