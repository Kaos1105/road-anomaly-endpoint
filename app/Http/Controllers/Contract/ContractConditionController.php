<?php

namespace App\Http\Controllers\Contract;

use App\Http\Controllers\Controller;

use App\Http\DTO\ResponseData;
use App\Models\BasicContract;
use App\Models\ContractCondition;

class ContractConditionController extends Controller
{
    public function __construct()
    {
    }

    public function index(BasicContract $basicContract): ResponseData
    {
        return $this->httpOk();
    }

    public function store(BasicContract $basicContract): ResponseData
    {
        return $this->httpOk();
    }

    public function update(BasicContract $basicContract, ContractCondition $condition): ResponseData
    {
        return $this->httpOk();
    }

    public function destroy(BasicContract $basicContract, ContractCondition $condition): ResponseData
    {

        return $this->httpNoContent();
    }

}
