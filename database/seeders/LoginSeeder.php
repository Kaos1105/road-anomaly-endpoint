<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Login;
use Illuminate\Database\Seeder;

class LoginSeeder extends Seeder
{
    public function run(): void
    {
        //
        $employeeIds = Employee::all()->pluck('id');
        if ($employeeIds->count()) {
            // Loop through each employee ID and create a login
            foreach ($employeeIds as $employeeId) {
                Login::factory()->state([
                    'employee_id' => $employeeId,
                ])->create();
            }
        }
    }
}
