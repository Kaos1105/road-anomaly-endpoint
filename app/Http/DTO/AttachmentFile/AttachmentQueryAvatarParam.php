<?php

namespace App\Http\DTO\AttachmentFile;

use App\Enums\Employee\AvatarFileEnum;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapOutputName(SnakeCaseMapper::class)]
class AttachmentQueryAvatarParam extends Data
{
    public function __construct(
        public string $attachableType,
        public int $attachableId,
        public ?string $fileName = AvatarFileEnum::FILE_NAME,
    ) {
    }
}
