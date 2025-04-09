<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Requests\Division\UpsertDivisionRequest;
use App\Http\Resources\Division\DivisionDetailResource;
use App\Http\Resources\Division\DivisionDropdownResource;
use App\Models\Division;
use App\Query\Division\DivisionDropdownQuery;
use App\Services\Division\IDivisionService;

class DivisionController extends Controller
{
    public function __construct(private readonly IDivisionService $divisionService)
    {
    }

    public function store(UpsertDivisionRequest $request): ResponseData
    {
        $data = $request->validated();
        $division = $this->divisionService->getRepo()->create($data);
        return $this->httpCreated(new DivisionDetailResource($division));
    }

    public function show(Division $division): ResponseData
    {
        $result = $this->divisionService->getRepo()->showDetail($division);
        return $this->httpOk(new DivisionDetailResource($result));
    }

    public function update(Division $division, UpsertDivisionRequest $request): ResponseData
    {
        $data = $request->validated();
        $division = $this->divisionService->getRepo()->update($data, $division->id);
        return $this->httpOk(new DivisionDetailResource($division));
    }

    public function destroy(Division $division): ResponseData
    {
        $childNames = $this->divisionService->getChildNames($division);
        if ($childNames) {
            return $this->httpBadRequest(msg: __('errors.can_not_delete', ['attr1' => $childNames]));
        }
        $this->divisionService->deleteRecord($division);
        return $this->httpNoContent();
    }

    public function dropdownDivisions(DivisionDropdownQuery $query): ResponseData
    {
        $result = $this->divisionService->findByQuery($query);

        return $this->httpOk(DivisionDropdownResource::collection($result));
    }
}
