<?php

declare(strict_types=1);

namespace App\Http\DTO\AccessHistory;

use App\Http\Resources\AccessHistory\UserSettingHistoryResource;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class UserPermissionSettingCardData extends Data
{
    public function __construct(
        public bool        $isAccessible,
        public ?Collection $records,
    )
    {
        $this->records = $records ? UserSettingHistoryResource::collection($records)->collection : null;

    }
}
