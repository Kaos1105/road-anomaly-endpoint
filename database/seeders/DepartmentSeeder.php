<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Site;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = Employee::select('id')->get()->pluck('id');
        $siteIds = Site::select('id')->get()->pluck('id');
        Department::factory(100)->customParameter($userIds, $siteIds)->create();
    }
}
