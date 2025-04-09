<?php

namespace Database\Seeders;

use App\Models\AccessPermission;
use App\Models\Employee;
use App\Models\System;
use Illuminate\Database\Seeder;

class AccessPermissionSeeder extends Seeder
{
    public function run(): void
    {
        //
        $employeeIds = Employee::all()->pluck('id');
        $systemIds = System::all()->pluck('id');
        if ($employeeIds->count()) {
            // Loop through each employee ID and create a login
            foreach ($systemIds as $systemId) {
                foreach ($employeeIds as $employeeId) {
                    AccessPermission::factory()->state([
                        'employee_id' => $employeeId,
                        'system_id' => $systemId,
                    ])->create();
                }
            }
        }
    }
}
