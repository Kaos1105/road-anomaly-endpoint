<?php

declare(strict_types=1);

namespace App\Http\DTO\Negotiation;

use App\Enums\AccessHistory\AccessibleTypeEnum;
use App\Enums\Employee\AvatarFileEnum;
use App\Http\Resources\AttachmentFile\AttachmentFileResource;
use App\Models\AttachmentFile;
use App\Models\MyCompanyEmployee;
use App\Models\NegotiationEmployee;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class CalendarMyCompanyEmployeeData extends Data
{
    public function __construct(
        public int                     $id,
        public string                  $lastName,
        public string                  $firstName,
        public ?AttachmentFileResource $attachmentFile,
    )
    {

    }

    public static function fromCollection(Collection $negotiableCollection): Collection
    {
        $collection = collect();
        $negotiableCollection->each(function (NegotiationEmployee $negotiationEmployee) use (&$collection) {
            if ($negotiationEmployee->negotiable_type === AccessibleTypeEnum::MY_COMPANY_EMPLOYEE && !empty($negotiationEmployee->negotiable)) {
                /**
                 * @var  $myCompanyEmployee MyCompanyEmployee
                 */
                $myCompanyEmployee = $negotiationEmployee->negotiable;

                $employee = $myCompanyEmployee?->employee;
                if ($employee) {
                    $avatar = $employee?->attachmentFiles?->filter(function (AttachmentFile $attachmentFile) {
                        return Str::upper(Str::substr($attachmentFile->file_name, 0, AvatarFileEnum::SYMBOL_LENGTH)) === AvatarFileEnum::FILE_NAME;
                    })?->first();
                    $collection->push(CalendarMyCompanyEmployeeData::from([
                        ...$employee->toArray(),
                        'attachment_file' => $avatar ? AttachmentFileResource::make($avatar, null) : null
                    ]));
                }
            }
        });
        return $collection;
    }
}
