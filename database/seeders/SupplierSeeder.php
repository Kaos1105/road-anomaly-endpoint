<?php

namespace Database\Seeders;

use App\Enums\Common\UseFlagEnum;
use App\Enums\Company\CompanyClassificationEnum;
use App\Models\Employee;
use App\Models\Site;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $siteIds = Site::select('id')->join('organization_companies', 'organization_companies.id', '=', 'organization_sites.company_id')->where('organization_companies.company_classification', CompanyClassificationEnum::SUPPLIER)
            ->get()->pluck('id')->toArray();

        $userIds = Employee::select('id')->where('use_classification', UseFlagEnum::USE)
            ->get()->pluck('id')->toArray();
        Supplier::factory(50)->customParameter($siteIds, $userIds, $userIds)->create();
    }
}
