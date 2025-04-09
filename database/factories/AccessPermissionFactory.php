<?php

namespace Database\Factories;

use App\Enums\AccessPermission\Permission1FlagEnum;
use App\Models\AccessPermission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AccessPermission>
 */
class AccessPermissionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'start_date' => fake()->dateTimeBetween($startDate = '-3 months', $endDate = 'now'),
            'permission_1' => Permission1FlagEnum::SYSTEM_USER,
        ];
    }
}
