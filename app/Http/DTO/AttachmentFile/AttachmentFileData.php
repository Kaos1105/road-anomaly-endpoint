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
class AttachmentFileData extends Data
{
    public function __construct(
        public ?int          $id,
        public int           $attachableId,
        public string        $attachableType,
        public ?string       $fileName,
        public ?string       $filePath,
        public ?UploadedFile $fileContent,
    )
    {
    }

    public static function mapFromMultiFile(MultiFileData $fileData): Collection
    {
        return collect($fileData->fileContent)->map(function (UploadedFile $file) use ($fileData) {
            return AttachmentFileData::from(
                [
                    'attachable_id' => $fileData->attachableId,
                    'attachable_type' => $fileData->attachableType,
                    'file_content' => $file,
                ]
            );
        });
    }
}
