<?php
declare(strict_types=1);

namespace App\Http\DTO\Auth;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class TwoFactorAuthenticationMailData extends Data
{
    public function __construct(
        public string  $token,
        public string  $lastName,
        public string  $firstName,
        public ?string $baseDomain = null,
    )
    {
        $baseDomain = $baseDomain ?? 'http://localhost:5173';
        $this->baseDomain = $baseDomain . '/authentication';
    }
}
