<?php

namespace Database\Factories;

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Transfer\ContractClassificationEnum;
use App\Enums\Transfer\TransferClassificationEnum;
use App\Models\Division;
use App\Models\Transfer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends Factory>
 */
class TransferFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = Transfer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'team_name' => substr($this->faker->username(), 0, 20),
            'position' => $this->faker->company,
            'contract_classification' => $this->faker->randomElement(ContractClassificationEnum::getValues()),
            'start_date' => $this->faker->date,
            'transfer_classification' => $this->faker->randomElement(TransferClassificationEnum::getValues()),
            'display_order' => $this->faker->numberBetween(1, DisplayOrderEnum::DEFAULT),
            'memo' => $this->faker->text,
            'created_at' => $this->faker->dateTime,
            'updated_at' => $this->faker->dateTime,
        ];
    }

    public function customParameter($userIds, $divisionIds): TransferFactory
    {
        return $this->state(function (array $attributes) use ($userIds, $divisionIds) {
            $divisionId = $this->faker->randomElement($divisionIds);
            $division = Division::find($divisionId);
            $division->load('department');
            return [
                'company_id' => $division->department->site->company_id,
                'site_id' => $division->department->site_id,
                'department_id' => $division->department_id,
                'division_id' => $division->id,
                'employee_id' =>$this->faker->randomElement($userIds),
                'created_by' => $this->faker->randomElement($userIds),
                'updated_by' => $this->faker->randomElement($userIds),
            ];
        });
    }
}
