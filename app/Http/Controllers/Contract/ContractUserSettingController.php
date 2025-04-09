<?php

namespace App\Http\Controllers\Contract;

use App\Http\Controllers\Controller;

use App\Http\DTO\ResponseData;

class ContractUserSettingController extends Controller
{
    public function __construct()
    {
    }

    public function store(): ResponseData
    {
        return $this->httpOk();
    }

    public function show(): ResponseData
    {
        return $this->httpOk();
    }

    public function update(): ResponseData
    {
        return $this->httpOk();
    }

}
