<?php

namespace App\Services\Excel;

use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;

interface IExportExcelService
{
    public function writeFileSystem(Collection $systemCollection): StreamedResponse;

    public function writeFileDisplay(Collection $screenCollection): StreamedResponse;

    public function writeFileContent(Collection $contentCollection): StreamedResponse;
}
