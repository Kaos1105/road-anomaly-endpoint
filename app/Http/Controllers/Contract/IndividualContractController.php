<?php

namespace App\Http\Controllers\Contract;

use App\Http\Controllers\Controller;

use App\Http\DTO\ResponseData;
use App\Http\Resources\Individual\IndividualContractItemResource;
use App\Http\Requests\IndividualContract\UpsertIndividualContractRequest;
use App\Http\Resources\IndividualContract\IndividualContractDetailResource;
use App\Models\BasicContract;
use App\Models\IndividualContract;
use App\Services\IndividualContract\IIndividualContractService;

class IndividualContractController extends Controller
{
    public function __construct(
        private readonly IIndividualContractService $individualContractService,
    )
    {
    }

    public function index(BasicContract $basicContract): ResponseData
    {
        $result = $this->individualContractService->getRepo()->findAll($basicContract);

        return $this->httpOk(IndividualContractItemResource::collection($result));
    }

    public function store(BasicContract $basicContract, UpsertIndividualContractRequest $individual): ResponseData
    {
        $validatedData = $individual->validated();
        $result = $this->individualContractService->getRepo()->create($validatedData);
        $individualDetail = $this->individualContractService->getRepo()->showDetail($result);

        return $this->httpOk(new IndividualContractDetailResource($individualDetail));
    }

    public function show(BasicContract $basicContract, IndividualContract $individual): ResponseData
    {
        $individualDetail = $this->individualContractService->getRepo()->showDetail($individual);
        
        return $this->httpOk(new IndividualContractDetailResource($individualDetail));
    }

    public function update(BasicContract $basicContract, IndividualContract $individual): ResponseData
    {
        return $this->httpOk();
    }

    public function destroy(BasicContract $basicContract, IndividualContract $individual): ResponseData
    {

        return $this->httpNoContent();
    }

}
