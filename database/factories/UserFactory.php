<?php

namespace Database\Factories;

use App\Enums\Common\StatisticClassificationEnum;
use App\Enums\Common\UseFlagEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'login_id' => fake()->userName,
            'password' => 'Pa$$w0rd',
            'name' => fake()->name,
        ];
    }

}
