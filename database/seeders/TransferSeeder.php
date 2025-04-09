<?php

namespace Database\Seeders;

use App\Enums\Common\UseFlagEnum;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Transfer;
use Illuminate\Database\Seeder;

class TransferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = Employee::select('id')->get()->pluck('id');
        $divisionIds = Division::select('id')->where('use_classification', UseFlagEnum::USE)->get()->pluck('id');
        Transfer::factory(100)->customParameter($userIds, $divisionIds)->create();
    }
}
