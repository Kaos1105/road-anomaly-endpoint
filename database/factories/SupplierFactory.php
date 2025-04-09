<?php

namespace Database\Factories;

use App\Enums\Supplier\SupplierClassificationEnum;
use App\Models\Supplier;
use Arr;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends Factory>
 */
class SupplierFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = Supplier::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'supplier_classification' => Arr::random(SupplierClassificationEnum::getValues()),
            'memo' => $this->faker->text,
            'created_at' => $this->faker->dateTime,
            'updated_at' => $this->faker->dateTime,
        ];
    }

    public function customParameter(array $salesStoreId, array $supplierPersonId, array $companyPersonId): SupplierFactory
    {

        return $this->state(function (array $attributes) use ($salesStoreId, $supplierPersonId, $companyPersonId) {
            return [
                'sales_store_id' => Arr::random($salesStoreId),
                'supplier_person_id' => Arr::random($supplierPersonId),
                'my_company_person_id' => Arr::random($companyPersonId),
                'created_by' => Arr::random($supplierPersonId),
                'updated_by' => Arr::random($supplierPersonId),
            ];
        });
    }
}
