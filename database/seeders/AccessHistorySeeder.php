<?php

namespace Database\Seeders;

use App\Enums\System\SystemCodeEnum;
use App\Models\AccessHistory;
use App\Models\AccessPermission;
use App\Models\Employee;
use App\Models\System;
use Illuminate\Database\Seeder;

class AccessHistorySeeder extends Seeder
{
    public function run(): void
    {
        $employeeIds = Employee::select('id')->get()->pluck('id')->toArray();
        $systemIds = System::select('id')->get()->pluck('id')->toArray();
        //
        $organizationSystemId = System::where('code', SystemCodeEnum::ORGANIZATION)->first();

        AccessHistory::factory(200)->customParameter($employeeIds, $systemIds)->create();
    }
}
