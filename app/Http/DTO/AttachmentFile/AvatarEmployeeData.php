<?php

declare(strict_types=1);

namespace App\Http\DTO\AttachmentFile;

use App\Http\Resources\AttachmentFile\AttachmentFileResource;
use App\Http\Resources\Employee\EmployeeAuthResource;
use App\Models\AttachmentFile;
use App\Models\Employee;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class AvatarEmployeeData extends Data
{
    public function __construct(
        public EmployeeAuthResource    $employee,
        public ?AttachmentFileResource $attachmentFile,
    )
    {

    }

    public static function fromModel(Employee $employee, ?AttachmentFile $attachmentFile): self
    {
        $attachmentFileData = $attachmentFile ? AttachmentFileResource::make($attachmentFile, null) : null;
        return new AvatarEmployeeData(EmployeeAuthResource::make($employee), $attachmentFileData);
    }
}
