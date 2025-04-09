<?php

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\Controller;
use App\Http\DTO\CompanyCalendar\CompanyCalendarData;
use App\Http\DTO\ResponseData;
use App\Http\Requests\CompanyCalendar\UpsertCompanyCalendarRequest;
use App\Http\Resources\CompanyCalendar\CompanyCalendarItemResource;
use App\Http\Resources\CompanyCalendar\CompanyCalendarDateResource;
use App\Services\Company\ICompanyService;
use App\Services\CompanyCalendar\ICompanyCalendarService;

class CompanyCalendarController extends Controller
{
    public function __construct(
        private readonly ICompanyCalendarService $companyCalendarService,
        private readonly ICompanyService         $companyService
    )
    {
    }

    public function index(): ResponseData
    {
        $company = $this->companyService->getRepo()->checkExistShinichiro();
        if (!$company) {
            return $this->httpOk();
        }
        $data = $this->companyCalendarService->getCalendarYear($company->id);
        return $this->httpOk(CompanyCalendarItemResource::collection($data));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpsertCompanyCalendarRequest $request): ResponseData
    {
        $validatedData = $request->validated();
        $dataCollection = collect(CompanyCalendarData::collect($validatedData['company_calendar']));
        $company = $this->companyService->getRepo()->checkExistShinichiro();
        if (!$company) {
            return $this->httpNotFound();
        }
        $this->companyCalendarService->upsertCompanyCalendar($company->id, $dataCollection);

        $year = $this->companyCalendarService->getYear($validatedData);

        $companyCalendar = $this->companyCalendarService->getCalendarYear($company->id, $year);

        return $this->httpCreated(CompanyCalendarItemResource::collection($companyCalendar));
    }

    public function checkDate(): ResponseData
    {
        $companyCalendar = $this->companyCalendarService->checkDate();
        if ($companyCalendar) {
            return $this->httpOk(new CompanyCalendarDateResource($companyCalendar));
        }
        return $this->httpOk();
    }
}
