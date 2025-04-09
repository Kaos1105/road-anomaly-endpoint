<?php

declare(strict_types=1);

namespace App\Http\DTO\SocialData;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class UpdateProgressSocialData extends Data
{
    public function __construct(
        public int     $dataProgress,
        public int     $executionType,
        public ?string $commentHistory,
        public ?string $comment,
    )
    {
    }
}
