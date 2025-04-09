<?php

namespace Database\Factories;

use App\Enums\AccessHistory\AccessActionTypeEnum;
use App\Enums\AccessHistory\AccessibleTypeEnum;
use App\Models\AccessHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AccessHistory>
 */
class AccessHistoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'access_at' => fake()->dateTimeBetween($startDate = '-3 months', $endDate = 'now'),
        ];
    }

    public function customParameter(array $employeeIds, array $systemIds): AccessHistoryFactory
    {
        $actions = [AccessActionTypeEnum::LOGIN, AccessActionTypeEnum::LOGOUT,
            AccessActionTypeEnum::START];
        return $this->state(function (array $attributes) use (
            $employeeIds, $systemIds, $actions
        ) {
            return [
                'action' => \Arr::random($actions),
                'employee_id' => $this->faker->randomElement($employeeIds),
                'system_id' => $this->faker->randomElement($systemIds),
            ];
        });
    }
}
