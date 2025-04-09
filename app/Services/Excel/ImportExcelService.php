<?php

namespace App\Services\Excel;

use App\Enums\Common\DateTimeEnum;
use App\Enums\Excel\ActionImportEnum;
use App\Enums\Excel\Content\ContentColumnExcelEnum;
use App\Enums\Excel\ExcelModelEnum;
use App\Enums\Excel\ExcelTemplateEnum;
use App\Enums\Excel\Screen\DisplayColumnExcelEnum;
use App\Enums\Excel\System\SystemColumnExcelEnum;
use App\Http\DTO\Excel\ContentImportData;
use App\Http\DTO\Excel\ContentInsertData;
use App\Http\DTO\Excel\OutputData;
use App\Http\DTO\Excel\ScreenImportData;
use App\Http\DTO\Excel\ScreenInsertData;
use App\Http\DTO\Excel\SystemImportData;
use App\Http\Requests\ScreenName\UpsertBatchContentRequest;
use App\Http\Requests\ScreenName\UpsertBatchDisplayRequest;
use App\Http\Requests\System\UpsertBatchSystemRequest;
use App\Models\Content;
use App\Models\Display;
use App\Models\Login;
use App\Models\System;
use App\Repositories\AccessPermission\IAccessPermissionRepository;
use App\Repositories\Content\IContentRepository;
use App\Repositories\Display\IDisplayRepository;
use App\Repositories\Employee\IEmployeeRepository;
use App\Repositories\System\ISystemRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ImportExcelService implements IImportExcelService
{
    public function __construct(
        public ISystemRepository           $systemRepository,
        public IDisplayRepository          $displayRepository,
        public IContentRepository          $contentRepository,
        public IEmployeeRepository         $employeeRepository,
        public IAccessPermissionRepository $accessPermissionRepository,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function readFileSystem(UploadedFile $file): ?OutputData
    {
        try {
            $resultRead = $this->readFile($file, SystemColumnExcelEnum::getValues(), ExcelModelEnum::SYSTEM);
            if ($resultRead->code != Response::HTTP_OK) {
                return $resultRead;
            }

            return match ($resultRead->action) {
                ActionImportEnum::ADD => $this->createMultipleSystem($resultRead->data),
                ActionImportEnum::DELETE => $this->deleteMultipleSystem($resultRead->data),
                default => $this->updateMultipleSystem($resultRead->data),
            };

        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage());
        }
    }


    public function readFileDisplay(UploadedFile $file): ?OutputData
    {
        try {
            $resultRead = $this->readFile($file, DisplayColumnExcelEnum::getValues(), ExcelModelEnum::DISPLAY);
            if ($resultRead->code != Response::HTTP_OK) {
                return $resultRead;
            }

            return match ($resultRead->action) {
                ActionImportEnum::ADD => $this->createMultipleDisplay($resultRead->data),
                ActionImportEnum::DELETE => $this->deleteMultipleDisplay($resultRead->data),
                default => $this->updateMultipleDisplay($resultRead->data),
            };

        } catch (\Throwable $exception) {

            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function readFileContent(UploadedFile $file): ?OutputData
    {
        try {
            $resultRead = $this->readFile($file, ContentColumnExcelEnum::getValues(), ExcelModelEnum::CONTENT);
            if ($resultRead->code != Response::HTTP_OK) {
                return $resultRead;
            }

            return match ($resultRead->action) {
                ActionImportEnum::ADD => $this->createMultipleContent($resultRead->data),
                ActionImportEnum::DELETE => $this->deleteMultipleContent($resultRead->data),
                default => $this->updateMultipleContent($resultRead->data),
            };

        } catch (\Throwable $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    private function readFile(UploadedFile $file, array $templateExcel, string $modelName): OutputData
    {
        $fileName = $file->getClientOriginalName();
        $fileName = str_replace('.csv', '', $fileName);
        $parts = explode('_', $fileName);
        if (empty($parts) || !in_array(end($parts), ActionImportEnum::getValues())) {
            return new OutputData(Response::HTTP_UNPROCESSABLE_ENTITY, null, null, __('errors.excel.template'));
        }
        $action = end($parts);
        $reader = IOFactory::createReader(ucfirst($file->getClientOriginalExtension()));

        $spreadsheet = $reader->load($file);
        $worksheet = $spreadsheet->getSheet(ExcelTemplateEnum::FIRST_SHEET);
        $highestRow = $worksheet->getHighestRow(ExcelTemplateEnum::COLUMN_START);
        $highestColumn = $worksheet->getHighestColumn(ExcelTemplateEnum::ROW_HEADING);

        $data = collect();

        if ($highestRow < ExcelTemplateEnum::ROW_RECORD_START) {
            return new OutputData(Response::HTTP_UNPROCESSABLE_ENTITY, $action, null, __('errors.excel.no_data'));
        }
        if ($highestColumn != end($templateExcel)) {
            return new OutputData(Response::HTTP_UNPROCESSABLE_ENTITY, $action, null, __('errors.excel.template'));
        }
        for ($row = ExcelTemplateEnum::ROW_RECORD_START; $row <= $highestRow; $row++) {
            $rowData = $worksheet->rangeToArray(ExcelTemplateEnum::COLUMN_START . $row . ':' . $highestColumn . $row, null, true, true, true);
            $originalRecord = $rowData[$row];
            $count = count(array_filter($originalRecord));
            if ($count > 0) {
                $valueColumns = [$row];
                foreach ($templateExcel as $column) {
                    $valueColumns[] = $originalRecord[$column];
                }
                $record = match ($modelName) {
                    ExcelModelEnum::SYSTEM => new SystemImportData(...$valueColumns),
                    ExcelModelEnum::DISPLAY => new ScreenImportData(...$valueColumns),
                    default => new ContentImportData(...$valueColumns),
                };
                $data->push($record);
            }
        }
        if ($data->count() == 0) {
            return new OutputData(Response::HTTP_UNPROCESSABLE_ENTITY, $action, null, __('errors.excel.no_data'));
        }
        return new OutputData(Response::HTTP_OK, $action, $data, null);
    }


    /**
     * @throws Throwable
     */
    private function createMultipleSystem(Collection $data): OutputData
    {
        $dataInsert = collect();
        $listErrors = collect();
        $codeUnique = [];

        /*** @var $login Login
         */
        $login = \Auth::user();
        $today = Carbon::now()->format(DateTimeEnum::DATE_TIME_FORMAT_V2);
        $createInfo = [
            'created_at' => $today,
            'created_by' => $login?->employee_id,
            'updated_at' => $today,
            'updated_by' => $login?->employee_id,
        ];

        $data->each(function (SystemImportData $dataSystem) use (&$listErrors, &$dataInsert, &$codeUnique, $createInfo) {

            $errors = $this->validateCreateRequest($dataSystem->toArray(), ExcelModelEnum::SYSTEM);

            if ($dataSystem->code && in_array($dataSystem->code, $codeUnique)) {
                $errors['code'] = [__('validation.unique', ['attribute' => __('attributes.system.code')])];
            } else {
                $codeUnique[] = $dataSystem->code;
            }

            if ($errors) {
                $errors['row'] = $dataSystem->row;
                $listErrors->push($errors);
            } else {
                $dataInsert->push([...$dataSystem->toArray(), ...$createInfo]);
            }
        });
        if ($listErrors->count() > 0) {
            return new OutputData(Response::HTTP_UNPROCESSABLE_ENTITY, ActionImportEnum::ADD, $listErrors, __('message.excel.error_record', ['record' => $listErrors->count()]));
        }
        $employees = $this->employeeRepository->getUserEmployees();
        DB::transaction(function () use ($dataInsert, $employees) {
            $dataInsert->each(function (array $item) use ($employees) {
                $system = $this->systemRepository->create($item);

                $this->accessPermissionRepository->createAccessPermission($system, $employees);
            });
        });

        return new OutputData(Response::HTTP_OK, ActionImportEnum::ADD, $dataInsert, __('message.excel.success_record', ['record' => $dataInsert->count()]));
    }

    /**
     * @throws Throwable
     */
    private function updateMultipleSystem(Collection $data): OutputData
    {
        $dataUpdate = collect();
        $listErrors = collect();
        /*** @var $login Login
         */
        $login = \Auth::user();
        $updateInfo = [
            'updated_at' => Carbon::now()->format(DateTimeEnum::DATE_TIME_FORMAT_V2),
            'updated_by' => $login?->employee_id,
        ];

        $data->each(function (SystemImportData $dataSystem) use (&$listErrors, &$dataUpdate, $updateInfo) {
            $system = System::whereCode($dataSystem->code_old)->first();
            $errors = null;

            if (!$system) {
                $errors['code_old'] = __('validation.exists', ['attribute' => __('attributes.system.code_old')]);
            } else {
                $systemRequest = UpsertBatchSystemRequest::create('', 'PUT', ['system' => $system, ...$dataSystem->toArray(), ...$updateInfo]);
                $validator = Validator::make($dataSystem->toArray(), $systemRequest->rules(), $systemRequest->messages(), $systemRequest->attributes());
                if ($validator->fails()) {
                    $errors = $validator->errors()->messages();
                }
                $dataUpdate->push([...$validator->validated(), 'id' => $system->id]);
            }

            if ($errors) {
                $errors['row'] = $dataSystem->row;
                $listErrors->push($errors);
            }
        });
        if ($listErrors->count() > 0) {
            return new OutputData(Response::HTTP_UNPROCESSABLE_ENTITY, ActionImportEnum::EDIT, $listErrors, __('message.excel.error_record', ['record' => $listErrors->count()]));
        }

        DB::transaction(function () use ($dataUpdate) {
            System::upsert($dataUpdate->toArray(), ['id']);
        });

        return new OutputData(Response::HTTP_OK, ActionImportEnum::EDIT, null, __('message.excel.success_record', ['record' => $dataUpdate->count()]));

    }

    /**
     * @throws Throwable
     */
    private function deleteMultipleSystem(Collection $data): OutputData
    {
        $dataDelete = collect();
        $listErrors = collect();
        $data->each(function (SystemImportData $dataSystem) use (&$listErrors, &$dataDelete) {
            $system = System::whereCode($dataSystem->code_old)->first();
            $errors = null;
            if ($system) {
                $countRelation = $this->systemRepository->checkRelations($system);
                if ($countRelation->displays_count > 0) {
                    $errors['code'] = __('errors.can_not_delete', ['attr1' => __('attributes.display.table')]);
                } else {
                    $dataDelete->push($system);
                }
            }
            if ($errors) {
                $errors['row'] = $dataSystem->row;
                $listErrors->push($errors);
            }
        });
        if ($listErrors->count() > 0) {
            return new OutputData(Response::HTTP_UNPROCESSABLE_ENTITY, ActionImportEnum::DELETE, $listErrors, __('message.excel.error_record', ['record' => $listErrors->count()]));
        }
        DB::transaction(function () use ($dataDelete) {
            System::query()->whereIn('id', $dataDelete->pluck('id'))->delete();
        });

        return new OutputData(Response::HTTP_OK, ActionImportEnum::DELETE, null, __('message.excel.success_record', ['record' => $dataDelete->count()]));
    }

    /**
     * @throws Throwable
     */
    private function createMultipleDisplay(Collection $data): OutputData
    {
        $dataInsert = collect();
        $listErrors = collect();

        /*** @var $login Login
         */
        $login = \Auth::user();
        $today = Carbon::now()->format(DateTimeEnum::DATE_TIME_FORMAT_V2);
        $createInfo = [
            'created_at' => $today,
            'created_by' => $login?->employee_id,
            'updated_at' => $today,
            'updated_by' => $login?->employee_id,
        ];

        $systems = System::get();
        $displays = Display::get();
        $systemCodeFile = $data->groupBy('code');

        $data->each(function (ScreenImportData $dataScreen) use (&$listErrors, &$dataInsert, $systems, $systemCodeFile, $createInfo, $displays) {
            $errors = $this->validateCreateRequest($dataScreen->toArray(), ExcelModelEnum::DISPLAY);

            /**
             * @var $existedSystem System
             */
            $existedSystem = $systems->firstWhere('code', $dataScreen->system_code);
            if ($existedSystem) {
                if ($dataScreen->code && $displays->has('code', $dataScreen->code)) {
                    $errors['code'] = [__('validation.unique', ['attribute' => __('attributes.display.code')])];
                } else {
                    //Check unique in file
                    $displays = $systemCodeFile->get($dataScreen->code);
                    if ($displays && $displays->count() > 1) {
                        $errors['code'] = [__('validation.unique', ['attribute' => __('attributes.display.code')])];
                    }
                }
                $dataInsert->push(ScreenInsertData::from([...$dataScreen->toArray(), 'system_id' => $existedSystem->id, ...$createInfo])->toArray());
            } else {
                $errors['system_code'] = [__('validation.exists', ['attribute' => __('attributes.system.code')])];
            }

            if ($errors) {
                $errors['row'] = $dataScreen->row;
                $listErrors->push($errors);
            }
        });
        if ($listErrors->count() > 0) {
            return new OutputData(Response::HTTP_UNPROCESSABLE_ENTITY, ActionImportEnum::ADD, $listErrors, __('message.excel.error_record', ['record' => $listErrors->count()]));
        }
        DB::transaction(function () use ($dataInsert) {
            Display::insert($dataInsert->toArray());
        });
        return new OutputData(Response::HTTP_OK, ActionImportEnum::ADD, $dataInsert, __('message.excel.success_record', ['record' => $dataInsert->count()]));

    }

    /**
     * @throws Throwable
     */
    private function updateMultipleDisplay(Collection $data): OutputData
    {
        $dataUpdate = collect();
        $listErrors = collect();

        /*** @var $login Login
         */
        $login = \Auth::user();
        $updateInfo = [
            'updated_at' => Carbon::now()->format(DateTimeEnum::DATE_TIME_FORMAT_V2),
            'updated_by' => $login?->employee_id,
        ];

        $updateScreenCode = $data->filter(function (ScreenImportData $dataScreen) {
            return $dataScreen->code_old != $dataScreen->code;
        })->pluck('code');

        $displays = Display::get();

        $data->each(function (ScreenImportData $dataScreen) use (&$listErrors, &$dataUpdate, &$displays, $updateScreenCode, $updateInfo) {
            $errors = null;
            $display = $displays->firstWhere('code', $dataScreen->code_old);

            $displayRequest = UpsertBatchDisplayRequest::create('', 'PUT', [...$dataScreen->toArray(), ...$updateInfo]);
            $validator = Validator::make($dataScreen->toArray(), $displayRequest->rules(), $displayRequest->messages(), $displayRequest->attributes());
            if ($validator->fails()) {
                $errors = $validator->errors()->messages();
            }

            if (!$display) {
                $errors['code_old'] = __('validation.exists', ['attribute' => __('attributes.system.code')]);
            } else {
                if ($dataScreen->code != $dataScreen->code_old) {
                    //Check unique
                    $foundCodes = $updateScreenCode->filter(fn(string $code) => $code == $dataScreen->code);
                    if ($foundCodes->count() > 1 || $displays->contains(fn(Display $item) => $item->code == $dataScreen->code)) {
                        $errors['code'] = [__('validation.unique', ['attribute' => __('attributes.content.no')])];
                    }
                }
                $dataValidate = $validator->validated();
                $dataUpdate->push([... $dataValidate, 'system_id' => $display->system_id, 'id' => $display->id]);
            }
            if ($errors) {
                $errors['row'] = $dataScreen->row;
                $listErrors->push($errors);
            }
        });
        if ($listErrors->count() > 0) {
            return new OutputData(Response::HTTP_UNPROCESSABLE_ENTITY, ActionImportEnum::EDIT, $listErrors, __('message.excel.error_record', ['record' => $listErrors->count()]));
        }

        DB::transaction(function () use ($dataUpdate) {
            Display::upsert($dataUpdate->toArray(), ['id']);
        });

        return new OutputData(Response::HTTP_OK, ActionImportEnum::EDIT, null, __('message.excel.success_record', ['record' => $dataUpdate->count()]));

    }

    /**
     * @throws Throwable
     */
    private function deleteMultipleDisplay(Collection $data): OutputData
    {
        $listErrors = collect();

        $codeDelete = $data->pluck('code');
        $deleteData = Display::query()->whereIn('code', $codeDelete)->withCount('questions')->get();

        $data->each(function (ScreenImportData $dataScreen) use (&$listErrors, $deleteData) {
            $errors = null;
            if ($deleteData->contains('code', $dataScreen->code)) {
                $display = $deleteData->firstWhere('code', $dataScreen->code);
                if ($display->questions_count > 0) {
                    $errors['code'] = __('errors.can_not_delete', ['attr1' => __('attributes.display.similar_FAQ')]);
                }
            }
            if ($errors) {
                $errors['row'] = $dataScreen->row;
                $listErrors->push($errors);
            }
        });

        if ($listErrors->count() > 0) {
            return new OutputData(Response::HTTP_UNPROCESSABLE_ENTITY, ActionImportEnum::DELETE, $listErrors, __('message.excel.error_record', ['record' => $listErrors->count()]));
        }
        DB::transaction(function () use ($deleteData) {
            Display::query()->whereIn('id', $deleteData->pluck('id'))->delete();
        });

        return new OutputData(Response::HTTP_OK, ActionImportEnum::DELETE, null, __('message.excel.success_record', ['record' => $deleteData->count()]));

    }

    /**
     * @throws Throwable
     */
    private function createMultipleContent(Collection $data): OutputData
    {
        $dataInsert = collect();
        $listErrors = collect();

        /*** @var $login Login
         */
        $login = \Auth::user();
        $today = Carbon::now()->format(DateTimeEnum::DATE_TIME_FORMAT_V2);
        $createInfo = [
            'created_at' => $today,
            'created_by' => $login?->employee_id,
            'updated_at' => $today,
            'updated_by' => $login?->employee_id,
        ];
        $displays = Display::with('contents')->get();
        $displayCodeFile = $data->groupBy('screen_code');

        $data->each(function (ContentImportData $dataContent) use (&$listErrors, &$dataInsert, $displays, $displayCodeFile, $createInfo) {

            $errors = $this->validateCreateRequest($dataContent->toArray(), ExcelModelEnum::CONTENT);

            /**
             * @var $existedDisplay Display
             */
            $existedDisplay = $displays->firstWhere('code', $dataContent?->screen_code);
            if ($dataContent->screen_code && $existedDisplay) {
                $existedContentNo = $existedDisplay->contents->pluck('no');

                if ($existedContentNo->contains($dataContent->no)) {
                    $errors['no'] = [__('validation.unique', ['attribute' => __('attributes.content.no')])];
                } else {
                    //Check unique in file
                    $contents = $displayCodeFile->get($dataContent->no);
                    if ($contents && $contents->count() > 1) {
                        $errors['no'] = [__('validation.unique', ['attribute' => __('attributes.content.no')])];
                    }
                }

                $dataInsert->push(ContentInsertData::from([...$dataContent->toArray(), 'display_id' => $existedDisplay->id, ...$createInfo])->toArray());
            } else {
                $errors['screen_code'] = [__('validation.exists', ['attribute' => __('attributes.excel.display_code')])];
            }
            if ($errors) {
                $errors['row'] = $dataContent->row;
                $listErrors->push($errors);
            }
        });

        if ($listErrors->count() > 0) {
            return new OutputData(Response::HTTP_UNPROCESSABLE_ENTITY, ActionImportEnum::ADD, $listErrors, __('message.excel.error_record', ['record' => $listErrors->count()]));
        }
        DB::transaction(function () use ($dataInsert) {
            Content::insert($dataInsert->toArray());
        });

        return new OutputData(Response::HTTP_OK, ActionImportEnum::ADD, $dataInsert, __('message.excel.success_record', ['record' => $dataInsert->count()]));

    }


    /**
     * @throws Throwable
     */
    private function updateMultipleContent(Collection $data): OutputData
    {
        $dataUpdate = collect();
        $listErrors = collect();

        /*** @var $login Login
         */
        $login = \Auth::user();
        $updateInfo = [
            'updated_at' => Carbon::now()->format(DateTimeEnum::DATE_TIME_FORMAT_V2),
            'updated_by' => $login?->employee_id,
        ];

        $displays = Display::with('contents')->get();

//        $displayCodeExisted = DisplayCodeExistedData::fromCollection($display)->values();

        $updateContentNo = $data->filter(function (ContentImportData $dataContent) use (&$updateContentNo) {
            return $dataContent->no_old != $dataContent->no;
        });

        $data->each(function (ContentImportData $dataContent) use (&$listErrors, &$dataUpdate, $displays, $updateContentNo, $updateInfo) {

            $errors = null;
            /**
             * @var $existedDisplay Display
             */
            $existedDisplay = $displays->firstWhere('code', $dataContent?->screen_code);
            if ($dataContent->screen_code && $existedDisplay) {
                $contentEdit = $existedDisplay->contents->firstWhere('no', $dataContent->no_old);
                $existedContentsNo = $existedDisplay->contents?->pluck('no');

                $contentRequest = UpsertBatchContentRequest::create('', 'PUT', [...$dataContent->toArray(), ...$updateInfo]);
                $validator = Validator::make($dataContent->toArray(), $contentRequest->rules(), $contentRequest->messages(), $contentRequest->attributes());
                if ($validator->fails()) {
                    $errors = $validator->errors()->messages();
                }

                if (!$existedContentsNo->contains($dataContent->no_old)) {
                    $errors['no_old'] = [__('validation.exists', ['attribute' => __('attributes.content.no')])];
                } else {
                    if ($dataContent->no != $dataContent->no_old) {
                        //Check unique
                        $duplicatedContents = $updateContentNo->filter(function (ContentImportData $importData) use ($dataContent) {
                            return $dataContent->screen_code == $importData->screen_code && $importData->no == $dataContent->no;
                        });
                        if ($duplicatedContents->count() > 2 || $existedContentsNo->contains($dataContent->no)) {
                            $errors['no'] = [__('validation.unique', ['attribute' => __('attributes.content.no')])];
                        }
                    }
                    $dataValidate = $validator->validate();
                    $dataUpdate->push([...$dataValidate, 'display_id' => $contentEdit->display_id, 'id' => $contentEdit->id]);
                }

            } else {
                $errors['screen_code'] = [__('validation.exists', ['attribute' => __('attributes.excel.display_code')])];
            }

            if ($errors) {
                $errors['row'] = $dataContent->row;
                $listErrors->push($errors);
            }
        });
        if ($listErrors->count() > 0) {
            return new OutputData(Response::HTTP_UNPROCESSABLE_ENTITY, ActionImportEnum::EDIT, $listErrors, __('message.excel.error_record', ['record' => $listErrors->count()]));
        }

        DB::transaction(function () use ($dataUpdate) {
            Content::upsert($dataUpdate->toArray(), ['id']);
        });

        return new OutputData(Response::HTTP_OK, ActionImportEnum::EDIT, null, __('message.excel.success_record', ['record' => $dataUpdate->count()]));

    }

    /**
     * @throws Throwable
     */
    private function deleteMultipleContent(Collection $data): OutputData
    {
        $displayCodeFile = $data->groupBy('screen_code');
        $ids = collect();
        DB::transaction(function () use ($displayCodeFile, &$ids) {
            $displayCodeFile->each(function ($dataContent, $screenCode) use (&$ids) {
                $contentsNo = $dataContent->pluck('no')->toArray();
                $contentsId = Content::query()->whereIn('no', $contentsNo)->whereHas('display', function ($displayQuery) use ($screenCode) {
                    $displayQuery->where('code', $screenCode);
                })->get('id')?->pluck('id');
                if ($contentsId) {
                    $ids = $ids->merge($contentsId);
                }
            });
            $this->contentRepository->deleteMultiple($ids?->toArray());
        });
        return new OutputData(Response::HTTP_OK, ActionImportEnum::DELETE, null, __('message.excel.success_record', ['record' => $ids->count()]));
    }

    private function validateCreateRequest(array $dataInsert, string $modelName): array|null
    {
        $request = Request::create('', 'POST', $dataInsert);

        $modelRequest = match ($modelName) {
            ExcelModelEnum::SYSTEM => UpsertBatchSystemRequest::createFrom($request),
            ExcelModelEnum::DISPLAY => UpsertBatchDisplayRequest::createFrom($request),
            default => UpsertBatchContentRequest::createFrom($request),
        };

        $validator = Validator::make($dataInsert, $modelRequest->rules(), $modelRequest->messages(), $modelRequest->attributes());
        $errors = null;
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
        }
        return $errors;
    }

}
