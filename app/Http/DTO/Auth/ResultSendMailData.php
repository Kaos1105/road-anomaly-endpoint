<?php
declare(strict_types=1);

namespace App\Http\DTO\Auth;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class ResultSendMailData extends Data
{
    public function __construct(
        public bool $isSendMail,
    )
    {
    }
}
