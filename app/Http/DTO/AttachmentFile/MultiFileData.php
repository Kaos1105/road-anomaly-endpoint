<?php

namespace App\Http\DTO\AttachmentFile;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class MultiFileData extends Data
{
    public function __construct(
        public int    $attachableId,
        public string $attachableType,
        public array  $fileContent,
    )
    {
    }
}
