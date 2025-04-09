<?php

namespace App\Http\DTO\AttachmentFile;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapOutputName(SnakeCaseMapper::class)]
class AttachmentQueryParam extends Data
{
    public function __construct(
        public string $attachableType,
        public int $attachableId,
    ) {
    }
}
