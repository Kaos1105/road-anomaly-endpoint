<?php

namespace App\Services\Excel;

use App\Enums\Common\DateTimeEnum;
use App\Enums\Excel\Content\ContentColumnExcelEnum;
use App\Enums\Excel\Content\ContentHeadingExcelEnum;
use App\Enums\Excel\ExcelModelEnum;
use App\Enums\Excel\ExcelTemplateEnum;
use App\Enums\Excel\Screen\DisplayColumnExcelEnum;
use App\Enums\Excel\Screen\DisplayHeadingExcelEnum;
use App\Enums\Excel\System\SystemColumnExcelEnum;
use App\Enums\Excel\System\SystemHeadingExcelEnum;
use App\Http\DTO\Excel\ExcelCellData;
use App\Models\Content;
use App\Models\Display;
use App\Models\System;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportExcelService implements IExportExcelService
{
    public function __construct()
    {
    }

    public function writeFileSystem(EloquentCollection $systemCollection): StreamedResponse
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $colKeys = collect(SystemColumnExcelEnum::getKeys());

        $colKeys->each(function (string $column) use ($sheet) {
            $sheet->setCellValue(SystemColumnExcelEnum::getValue($column) . ExcelTemplateEnum::ROW_HEADING, SystemHeadingExcelEnum::getValue($column));
        });

        $systemCollection->each(function (System $system, $index) use ($sheet) {
            $rowIdx = ExcelTemplateEnum::ROW_HEADING;
            $row = $this->setSystemRowValue($rowIdx, $index + ExcelTemplateEnum::ROW_HEADING, $system);
            $row->each(function (ExcelCellData $data) use ($sheet) {
                $sheet->setCellValue($data->cellNo, $data->cellValue);
            });
        });

        $fileName = $this->getFileName(ExcelModelEnum::SYSTEM);
        return $this->downloadExcel($spreadsheet, $fileName);

    }

    public function writeFileDisplay(EloquentCollection $screenCollection): StreamedResponse
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $colKeys = collect(DisplayColumnExcelEnum::getKeys());

        $colKeys->each(function (string $column) use ($sheet) {
            $sheet->setCellValue(DisplayColumnExcelEnum::getValue($column) . ExcelTemplateEnum::ROW_HEADING, DisplayHeadingExcelEnum::getValue($column));
        });

        $screenCollection->each(function (Display $display, $index) use ($sheet) {
            $rowIdx = ExcelTemplateEnum::ROW_HEADING;
            $row = $this->setScreenRowValue($rowIdx, $index + ExcelTemplateEnum::ROW_HEADING, $display);
            $row->each(function (ExcelCellData $data) use ($sheet) {
                $sheet->setCellValue($data->cellNo, $data->cellValue);
            });
        });

        $fileName = $this->getFileName(ExcelModelEnum::DISPLAY);
        return $this->downloadExcel($spreadsheet, $fileName);
    }

    public function writeFileContent(EloquentCollection $contentCollection): StreamedResponse
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $colKeys = collect(ContentColumnExcelEnum::getKeys());

        $colKeys->each(function (string $column) use ($sheet) {
            $sheet->setCellValue(ContentColumnExcelEnum::getValue($column) . ExcelTemplateEnum::ROW_HEADING, ContentHeadingExcelEnum::getValue($column));
        });

        $contentCollection->each(function (Content $content, $index) use ($sheet) {
            $rowIdx = ExcelTemplateEnum::ROW_HEADING;
            $row = $this->setContentRowValue($rowIdx, $index + ExcelTemplateEnum::ROW_HEADING, $content);
            $row->each(function (ExcelCellData $data) use ($sheet) {
                $sheet->setCellValue($data->cellNo, $data->cellValue);
            });
        });

        $fileName = $this->getFileName(ExcelModelEnum::CONTENT);
        return $this->downloadExcel($spreadsheet, $fileName);
    }


    protected function downloadExcel(Spreadsheet $spreadsheet, string $fileName): StreamedResponse
    {
        $writer = new Csv($spreadsheet);
        $response = new StreamedResponse(function () use ($writer) {
            echo "\xEF\xBB\xBF"; // UTF-8 BOM
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $fileName . '"');
        $response->headers->set('Cache-Control', 'max-age=0');

        return $response;
    }

    private function getFileName(string $model): string
    {
        return Carbon::now()->format(DateTimeEnum::FILE_TITLE_FORMAT) . "_" . $model . "." . ExcelTemplateEnum::CSV_TYPE;
    }

    protected function setSystemRowValue(int $rowIdx, int $index, System $system): Collection
    {
        $currRowIdx = $rowIdx + $index;
        $row = collect();

        $row->push(new ExcelCellData(SystemColumnExcelEnum::CODE_OLD . $currRowIdx, $system->code));
        $row->push(new ExcelCellData(SystemColumnExcelEnum::CODE . $currRowIdx, $system->code));
        $row->push(new ExcelCellData(SystemColumnExcelEnum::NAME . $currRowIdx, $system->name));
        $row->push(new ExcelCellData(SystemColumnExcelEnum::OVERVIEW . $currRowIdx, $system->overview));
        $row->push(new ExcelCellData(SystemColumnExcelEnum::START_DATE . $currRowIdx, $system->start_date));
        $row->push(new ExcelCellData(SystemColumnExcelEnum::END_DATE . $currRowIdx, $system->end_date));
        $row->push(new ExcelCellData(SystemColumnExcelEnum::DEFAULT_PERMISSION_2 . $currRowIdx, $system->default_permission_2));
        $row->push(new ExcelCellData(SystemColumnExcelEnum::DEFAULT_PERMISSION_3 . $currRowIdx, $system->default_permission_3));
        $row->push(new ExcelCellData(SystemColumnExcelEnum::DEFAULT_PERMISSION_4 . $currRowIdx, $system->default_permission_4));
        $row->push(new ExcelCellData(SystemColumnExcelEnum::MEMO . $currRowIdx, $system->memo));
        $row->push(new ExcelCellData(SystemColumnExcelEnum::DISPLAY_ORDER . $currRowIdx, $system->display_order));
        $row->push(new ExcelCellData(SystemColumnExcelEnum::USE_CLASSIFICATION . $currRowIdx, $system->use_classification));

        return $row;
    }

    protected function setScreenRowValue(int $rowIdx, int $index, Display $display): Collection
    {
        $currRowIdx = $rowIdx + $index;
        $row = collect();

        $row->push(new ExcelCellData(DisplayColumnExcelEnum::SYSTEM_CODE . $currRowIdx, $display->system->code));
        $row->push(new ExcelCellData(DisplayColumnExcelEnum::CODE_OLD . $currRowIdx, $display->code));
        $row->push(new ExcelCellData(DisplayColumnExcelEnum::CODE . $currRowIdx, $display->code));
        $row->push(new ExcelCellData(DisplayColumnExcelEnum::DISPLAY_CLASSIFICATION . $currRowIdx, $display->display_classification));
        $row->push(new ExcelCellData(DisplayColumnExcelEnum::NAME . $currRowIdx, $display->name));
        $row->push(new ExcelCellData(DisplayColumnExcelEnum::MEMO . $currRowIdx, $display->memo));
        $row->push(new ExcelCellData(DisplayColumnExcelEnum::DISPLAY_ORDER . $currRowIdx, $display->display_order));
        $row->push(new ExcelCellData(DisplayColumnExcelEnum::USE_CLASSIFICATION . $currRowIdx, $display->use_classification));

        return $row;
    }

    protected function setContentRowValue(int $rowIdx, int $index, Content $content): Collection
    {
        $currRowIdx = $rowIdx + $index;
        $row = collect();

        $row->push(new ExcelCellData(ContentColumnExcelEnum::SCREEN_CODE . $currRowIdx, $content->display->code));
        $row->push(new ExcelCellData(ContentColumnExcelEnum::NO_OLD . $currRowIdx, $content->no));
        $row->push(new ExcelCellData(ContentColumnExcelEnum::NO . $currRowIdx, $content->no));
        $row->push(new ExcelCellData(ContentColumnExcelEnum::CONTENT_CLASSIFICATION . $currRowIdx, $content->classification));
        $row->push(new ExcelCellData(ContentColumnExcelEnum::NAME . $currRowIdx, $content->name));
        $row->push(new ExcelCellData(ContentColumnExcelEnum::PERMISSION_1 . $currRowIdx, $content->permission_1));
        $row->push(new ExcelCellData(ContentColumnExcelEnum::PERMISSION_2 . $currRowIdx, $content->permission_2));
        $row->push(new ExcelCellData(ContentColumnExcelEnum::PERMISSION_3 . $currRowIdx, $content->permission_3));
        $row->push(new ExcelCellData(ContentColumnExcelEnum::PERMISSION_4 . $currRowIdx, $content->permission_4));
        $row->push(new ExcelCellData(ContentColumnExcelEnum::MEMO . $currRowIdx, $content->memo));
        $row->push(new ExcelCellData(ContentColumnExcelEnum::DISPLAY_ORDER . $currRowIdx, $content->display_order));
        $row->push(new ExcelCellData(ContentColumnExcelEnum::USE_CLASSIFICATION . $currRowIdx, $content->use_classification));

        return $row;
    }
}
