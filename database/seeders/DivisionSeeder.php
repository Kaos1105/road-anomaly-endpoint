<?php

namespace Database\Seeders;

use App\Enums\Common\UseFlagEnum;
use App\Models\Department;
use App\Models\Division;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = Employee::select('id')->get()->pluck('id');
        $departmentIds = Department::select('id')->where('use_classification', UseFlagEnum::USE)->get()->pluck('id');
        Division::factory(200)->customParameter($userIds, $departmentIds)->create();
    }
}
