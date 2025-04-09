<?php

namespace App\Http\DTO\AnswerFile;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class UploadResultData extends Data
{
    public function __construct(
        public string|null $filePath = null,
        public string|null $fileName = null
    )
    {
    }
}
