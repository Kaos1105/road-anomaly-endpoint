<?php

namespace Database\Factories;

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\PreviousNameFlagEnum;
use App\Enums\Common\RepresentFlagEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\Department\DepartmentClassificationEnum;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends Factory>
 */
class DepartmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = Department::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' =>  substr($this->faker->username(), 0, 20),
            'long_name' => $this->faker->company,
            'short_name' => $this->faker->company,
            'kana' => $this->faker->company,
            'previous_name' => $this->faker->company,
            'previous_name_flg' => $this->faker->randomElement(PreviousNameFlagEnum::getValues()),
            'start_date' => $this->faker->date,
            'represent_flg' => $this->faker->randomElement(RepresentFlagEnum::getValues()),
            'department_classification' => $this->faker->randomElement(DepartmentClassificationEnum::getValues()),
            'display_order' => $this->faker->numberBetween(0, DisplayOrderEnum::DEFAULT),
            'use_classification' => $this->faker->randomElement(UseFlagEnum::getValues()),
            'memo' => $this->faker->text,
            'created_at' => $this->faker->dateTime,
            'updated_at' => $this->faker->dateTime,
        ];
    }

    public function customParameter($userIds, $siteIds): DepartmentFactory
    {

        return $this->state(function (array $attributes) use ($userIds, $siteIds) {
            return [
                'site_id' => $this->faker->randomElement($siteIds),
                'created_by' => $this->faker->randomElement($userIds),
                'updated_by' => $this->faker->randomElement($userIds),

            ];
        });
    }
}
