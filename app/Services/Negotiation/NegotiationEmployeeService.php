<?php

namespace App\Services\Negotiation;

use App\Repositories\Negotiation\INegotiationEmployeeRepository;

class NegotiationEmployeeService implements INegotiationEmployeeService
{
    public function __construct(
        public INegotiationEmployeeRepository $negotiationEmployeeRepository,
    )
    {
    }

    public function getRepo(): INegotiationEmployeeRepository
    {
        return $this->negotiationEmployeeRepository;
    }

}
