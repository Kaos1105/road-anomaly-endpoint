<?php

declare(strict_types=1);

namespace App\Http\DTO\Excel;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class ContentInsertData extends Data
{
    public function __construct(
        public ?int            $display_id,
        public ?string         $no,
        public int|string|null $classification,
        public ?string         $name,
        public int|string|null $permission_1,
        public int|string|null $permission_2,
        public int|string|null $permission_3,
        public int|string|null $permission_4,
        public ?string         $memo,
        public int|string|null $display_order,
        public int|string|null $use_classification,
        public ?int            $created_by = null,
        public ?int            $updated_by = null,
        public ?string         $created_at = null,
        public ?string         $updated_at = null,
    )
    {
    }

}
