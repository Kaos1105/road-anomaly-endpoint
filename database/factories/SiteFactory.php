<?php

namespace Database\Factories;

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\RepresentFlagEnum;
use App\Enums\Common\UseFlagEnum;
use App\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends Factory>
 */
class SiteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = Site::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->userName,
            'long_name' => $this->faker->company,
            'phone' => $this->faker->phoneNumber,
            'address_1' => $this->faker->city,
            'address_2' => $this->faker->word,
            'address_3' => $this->faker->word,
            'start_date' => $this->faker->date,
            'represent_flg' => $this->faker->randomElement(RepresentFlagEnum::getValues()),
            'display_order' => $this->faker->numberBetween(0, DisplayOrderEnum::DEFAULT),
            'use_classification' => $this->faker->randomElement(UseFlagEnum::getValues()),
            'memo' => $this->faker->text,
            'created_at' => $this->faker->dateTime,
            'updated_at' => $this->faker->dateTime,
        ];
    }
}
