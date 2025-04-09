<?php

namespace App\Http\Controllers\SNET;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Requests\BatchRegistration\ImportFileRequest;
use App\Services\Content\IContentService;
use App\Services\Display\IDisplayService;
use App\Services\Excel\IExportExcelService;
use App\Services\Excel\IImportExcelService;
use App\Services\System\ISystemService;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExcelFileController extends Controller
{
    public function __construct(
        private readonly IImportExcelService $importExcelService,
        private readonly IExportExcelService $exportExcelService,
        public ISystemService                $systemService,
        public IDisplayService               $displayService,
        public IContentService               $contentService,
    )
    {
    }

    public function importSystem(ImportFileRequest $request): ResponseData
    {
        $file = $request->validated('file');
        $output = $this->importExcelService->readFileSystem($file);

        return $this->httpOk($output);
    }

    public function importDisplay(ImportFileRequest $request): ResponseData
    {
        $file = $request->validated('file');
        $output = $this->importExcelService->readFileDisplay($file);

        return $this->httpOk($output);
    }

    public function importContent(ImportFileRequest $request): ResponseData
    {
        $file = $request->validated('file');
        $output = $this->importExcelService->readFileContent($file);

        return $this->httpOk($output);
    }

    public function exportSystem(): StreamedResponse|ResponseData
    {
        $systems = $this->systemService->exportData();
        return $this->exportExcelService->writeFileSystem($systems);

    }

    public function exportDisplay(): StreamedResponse|ResponseData
    {
        $screens = $this->displayService->exportData();
        return $this->exportExcelService->writeFileDisplay($screens);
    }

    public function exportContent(): StreamedResponse|ResponseData
    {
        $contents = $this->contentService->exportData();
        return $this->exportExcelService->writeFileContent($contents);
    }

}
