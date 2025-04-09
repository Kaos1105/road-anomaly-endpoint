<?php

namespace Database\Factories;

use App\Enums\System\OperationFlagEnum;
use App\Models\System;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends Factory<System>
 */
class SystemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'start_date' => fake()->dateTimeBetween($startDate = '-3 months', $endDate = 'now'),
        ];
    }
}
