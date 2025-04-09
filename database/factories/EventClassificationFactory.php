<?php

namespace Database\Factories;

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;
use App\Models\EventClassification;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends Factory>
 */
class EventClassificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = EventClassification::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->company(),
            'description' => $this->faker->paragraph(),
            'operation_rule' => $this->faker->paragraph(),
            'social_criteria' => $this->faker->paragraph(),
            'display_order' => $this->faker->numberBetween(0, DisplayOrderEnum::DEFAULT),
            'use_classification' => $this->faker->randomElement(UseFlagEnum::getValues()),
            'memo' => $this->faker->text,
            'created_at' => $this->faker->dateTime,
            'updated_at' => $this->faker->dateTime,
        ];
    }

    public function customParameter(array $userIds): EventClassificationFactory
    {

        return $this->state(function (array $attributes) use ($userIds) {
            return [
                'created_by' => $this->faker->randomElement($userIds),
                'updated_by' => $this->faker->randomElement($userIds),
            ];
        });
    }
}
