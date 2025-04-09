<?php

namespace Database\Factories;

use App\Enums\Common\PreviousNameFlagEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\Company\CompanyClassificationEnum;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->bothify('?###'),
            'long_name' => $this->faker->company,
            'short_name' => $this->faker->word,
            'kana' => $this->faker->word,
            'start_date' => $this->faker->dateTimeThisDecade()->format('Y-m-d'),
            'end_date' => $this->faker->dateTimeThisDecade()->format('Y-m-d'),
            'company_classification' => $this->faker->randomElement(CompanyClassificationEnum::getValues()),
            'group_name' => $this->faker->word,
            'previous_name' => $this->faker->word,
            'previous_name_flg' => $this->faker->randomElement(PreviousNameFlagEnum::getValues()),
            'en_notation' => $this->faker->word,
            'memo' => $this->faker->sentence(10),
            'display_order' => $this->faker->numberBetween(1, 999999),
            'use_classification' => $this->faker->randomElement(UseFlagEnum::getValues()),
            'created_by' => $this->faker->numberBetween(1, 100),
            'updated_by' => $this->faker->numberBetween(1, 100),
        ];
    }
}
