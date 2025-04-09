<?php

namespace App\Query\Customer;

use App\Models\Customer;
use App\Repositories\Customer\Filter\FilterByAffiliatedCompanyId;
use App\Repositories\Customer\Filter\FilterByCustomerEmployeeName;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class SocialDataUnRegisCustomerQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $query = Customer::query();
        parent::__construct($query, $request);
        $this->allowedFilters([
            AllowedFilter::exact('responsible_id'),
            AllowedFilter::exact('category_name'),
            AllowedFilter::custom('customer_name', new FilterByCustomerEmployeeName()),
            AllowedFilter::custom('affiliated_company_id', new FilterByAffiliatedCompanyId()),
        ]);
    }
}
