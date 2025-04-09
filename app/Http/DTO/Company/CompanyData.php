<?php

declare(strict_types=1);

namespace App\Http\DTO\Company;

use App\Enums\Company\SortKeyEnum;
use App\Http\DTO\SortingData;
use App\Http\Resources\Company\CompanyItemResource;
use App\Models\Company;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class CompanyData extends SortingData
{
    public function __construct(
        public CompanyItemResource $company
    )
    {
    }

    public static function mapCollection(Collection $company): Collection
    {
        $dataCollection = $company->map(function (Company $item) {
            return self::fromModel($item);
        });

        return parent::sortCollection($dataCollection, SortKeyEnum::SORT_LIST)->values();
    }

    public static function fromModel(Company $company): CompanyItemResource
    {
        return CompanyItemResource::make($company);
    }
}
