<?php

declare(strict_types=1);

namespace App\Http\DTO\AccessHistory;

use App\Enums\Common\DateTimeEnum;
use App\Models\Login;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class AccessHistoryData extends Data
{
    public function __construct(
        public int     $systemId,
        public string  $action,
        public ?string $accessibleType,
        public ?int    $employeeId,
        public ?int    $accessibleId,
        public ?string $message,
        public ?string $accessAt,
    )
    {
        /*** @var $login Login
         */
        $login = \Auth::user();
        $this->employeeId = $login->employee_id;
        $this->accessAt = Carbon::now()->format(DateTimeEnum::DATE_TIME_FORMAT_V2);
    }
}
