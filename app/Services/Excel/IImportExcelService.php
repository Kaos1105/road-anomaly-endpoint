<?php

namespace App\Services\Excel;

use App\Http\DTO\Excel\OutputData;
use Illuminate\Http\UploadedFile;

interface IImportExcelService
{
    public function readFileSystem(UploadedFile $file): ?OutputData;

    public function readFileDisplay(UploadedFile $file): ?OutputData;

    public function readFileContent(UploadedFile $file): ?OutputData;

}
