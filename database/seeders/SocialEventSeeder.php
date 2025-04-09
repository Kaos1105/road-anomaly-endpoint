<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\EventClassification;
use App\Models\SocialEvent;
use App\Models\ManagementGroup;
use Illuminate\Database\Seeder;

class SocialEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employeeIds = Employee::select('id')->get()->pluck('id');
        $eventClassifications = EventClassification::select('id')->get()->pluck('id');
        $managementGroupIds = ManagementGroup::select('id')->get()->pluck('id');

        SocialEvent::factory(20)->customParameter($employeeIds->toArray(),
            $managementGroupIds->toArray(), $eventClassifications->toArray())->create();
    }
}
