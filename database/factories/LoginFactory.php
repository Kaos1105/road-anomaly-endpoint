<?php

namespace Database\Factories;

use App\Models\Login;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends Factory<Login>
 */
class LoginFactory extends Factory
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
            'login_id' => $this->generateUserName(),
            'password' => 'password',
        ];
    }

    /**
     * Generate a username with a minimum of 8 characters.
     *
     * @return string
     */
    protected function generateUserName(): string
    {
        $userName = fake()->userName();

        // Ensure the username has a minimum of 8 characters
        while (strlen($userName) < 8) {
            $userName .= Str::random(1); // Add random characters until it meets the requirement
        }

        return $userName;
    }
}
