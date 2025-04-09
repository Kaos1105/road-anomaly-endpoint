<?php

namespace App\Http\DTO\Common;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Helpers\DisplayHelper;
use App\Models\Employee;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class UserInfoData extends Data
{
    public function __construct(
        public ?string $date,
        public ?string $name,
    )
    {

    }
    public static function fromData(?Employee $employee, ?Carbon $date): UserInfoData
    {
        return UserInfoData::from([
            'name' => $employee ? DisplayHelper::formatEmployeeName($employee) : null,
            'date' => $date ? DateTimeHelper::formatDateTime($date, DateTimeEnum::DATE_TIME_FORMAT) : null,
        ]);
    }
}
