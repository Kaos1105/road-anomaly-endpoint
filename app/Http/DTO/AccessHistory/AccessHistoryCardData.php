<?php

declare(strict_types=1);

namespace App\Http\DTO\AccessHistory;

use App\Http\Resources\AccessHistory\AccessItemResource;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class AccessHistoryCardData extends Data
{
    public function __construct(
        public bool        $isEnableBtn,
        public ?Collection $records,
    )
    {
        $this->records = $records ? AccessItemResource::collection($records)->collection : null;

    }
}
