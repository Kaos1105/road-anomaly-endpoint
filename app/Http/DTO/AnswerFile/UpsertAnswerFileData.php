<?php

namespace App\Http\DTO\AnswerFile;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class UpsertAnswerFileData extends Data
{
    public function __construct(
        public ?int   $widthSize,
        /** @var array<int, UploadedFile> */
        public ?array $fileContent,
    )
    {
    }
}
