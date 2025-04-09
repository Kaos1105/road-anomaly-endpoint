<?php

namespace App\Http\DTO\Common;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class ZipCodeData extends Data
{
    public function __construct(
        public string $address_1,
        public string $address_2,
        public string $address_3,
        public string $kana1,
        public string $kana2,
        public string $kana3,
        public string $prefcode,
        public string $zipcode,
    )
    {
    }

    public static function fromCollection(array $results): Collection
    {
        return collect($results)->map(function ($item) {
            return new self(
                $item['address1'],
                $item['address2'],
                $item['address3'],
                $item['kana1'],
                $item['kana2'],
                $item['kana3'],
                $item['prefcode'],
                $item['zipcode'],
            );
        });
    }
}
