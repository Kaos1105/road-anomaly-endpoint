<?php

namespace Database\Factories;

use App\Enums\Common\UseFlagEnum;
use App\Enums\SocialEvent\EventProgressClassificationEnum;
use App\Models\SocialEvent;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * @extends Factory>
 */
class SocialEventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = SocialEvent::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_title' => $this->faker->unique()->firstName,
            'event_progress' => Arr::random(EventProgressClassificationEnum::getValues()),
            'planned_start' => $this->faker->dateTime,
            'creation_deadline' => $this->faker->dateTime,
            'approval_deadline' => $this->faker->dateTime,
            'order_deadline' => $this->faker->dateTime,
            'planned_completion' => $this->faker->dateTime,
            'plan_comment' => $this->faker->paragraph(),
            'actual_comment' => $this->faker->paragraph(),
            'use_classification' => $this->faker->randomElement(UseFlagEnum::getValues()),
            'memo' => $this->faker->text,
            'created_at' => $this->faker->dateTime,
            'updated_at' => $this->faker->dateTime,
        ];
    }

    public function customParameter(array $userIds, array $managementGroupIds, array $eventClassificationIds): SocialEventFactory
    {

        return $this->state(function () use ($userIds, $managementGroupIds, $eventClassificationIds) {
            return [
                'group_id' => $this->faker->randomElement($managementGroupIds),
                'event_id' => $this->faker->randomElement($eventClassificationIds),
                'created_by' => $this->faker->randomElement($userIds),
                'updated_by' => $this->faker->randomElement($userIds),
            ];
        });
    }
}
