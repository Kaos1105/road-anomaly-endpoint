<?php

namespace App\Services\Negotiation;

use App\Models\Employee;
use App\Repositories\Employee\IEmployeeRepository;
use App\Repositories\Negotiation\INegotiationEmployeeRepository;

interface INegotiationEmployeeService
{
    public function getRepo(): INegotiationEmployeeRepository;



}
