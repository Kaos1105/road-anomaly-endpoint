<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\EventClassification;
use Illuminate\Database\Seeder;

class EventClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = Employee::select('id')->get()->pluck('id');
        EventClassification::factory(10)->customParameter($userIds->toArray())->create();
    }
}
