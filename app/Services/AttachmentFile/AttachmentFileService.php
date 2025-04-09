<?php

namespace App\Services\AttachmentFile;

use App\Enums\AccessHistory\AccessActionTypeEnum;
use App\Enums\AccessHistory\AccessibleTypeEnum;
use App\Enums\AccessHistory\AccessibleTypeSystemCodeEnum;
use App\Enums\Common\AttachableTypeEnum;
use App\Helpers\FileHelper;
use App\Helpers\SystemHelper;
use App\Http\DTO\AttachmentFile\AttachmentFileData;
use App\Http\DTO\AttachmentFile\AttachmentQueryAvatarParam;
use App\Http\DTO\AttachmentFile\AttachmentQueryParam;
use App\Models\AccessHistory;
use App\Models\AttachmentFile;
use App\Models\BasicContract;
use App\Models\Company;
use App\Models\Department;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Facility;
use App\Models\IndividualContract;
use App\Models\Login;
use App\Models\Negotiation;
use App\Models\Product;
use App\Models\Site;
use App\Query\AttachmentFile\AttachmentFileAllQuery;
use App\Repositories\AttachmentFile\IAttachmentFileRepository;
use Auth;
use BenSampo\Enum\Exceptions\InvalidEnumKeyException;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class AttachmentFileService implements IAttachmentFileService
{
    public function __construct(
        public IAttachmentFileRepository $attachmentFileRepository,
    )
    {
    }

    public function getRepo(): IAttachmentFileRepository
    {
        return $this->attachmentFileRepository;
    }

    /**
     * @throws Throwable
     */
    public function createAttachments(Collection $attachmentFiles): Collection
    {
        $result = collect();
        DB::transaction(function () use ($attachmentFiles, &$result) {
            $accessHistories = [];
            $attachmentFiles->each(
            /**
             * @throws InvalidEnumKeyException
             */
                function (AttachmentFileData $attachmentFile) use (&$result, &$accessHistories) {
                    $uploadResult = FileHelper::uploadFileToS3($attachmentFile);
                    if ($uploadResult) {
                        /**
                         * @var $login Login
                         */
                        $login = Auth::user();

                        $attachment = AttachmentFile::create([
                            'file_name' => $attachmentFile->fileContent->getClientOriginalName(),
                            'file_path' => $uploadResult,
                            'attachable_type' => $attachmentFile->attachableType,
                            'attachable_id' => $attachmentFile->attachableId,
                            'created_by' => $login->employee_id,
                            'created_at' => Carbon::now(),
                        ]);
                        $accessHistories[] = [
                            'employee_id' => \Auth::user()->employee_id,
                            'system_id' => SystemHelper::getSystemId(AccessibleTypeSystemCodeEnum::fromKey($attachmentFile->attachableType)->value),
                            'action' => AccessActionTypeEnum::UPLOAD,
                            'accessible_type' => AccessibleTypeEnum::ATTACHMENT_FILE,
                            'accessible_id' => $attachment->id,
                            'message' => $attachment->file_name,
                            'access_at' => Carbon::now(),
                        ];
                        $result->push($attachment);
                    }
                });
            if (!empty($accessHistories)) {
                AccessHistory::insert($accessHistories);
            }
        });
        return $result;
    }

    /**
     * @throws InvalidEnumKeyException
     * @throws Throwable
     */
    public function deleteAttachment(AttachmentFile $attachmentFile): bool
    {
        $result = false;
        DB::transaction(function () use ($attachmentFile, &$result) {
            $deleteFile = Storage::disk('s3')->delete($attachmentFile->file_path);
            if ($deleteFile) {
                AccessHistory::create([
                    'employee_id' => \Auth::user()->employee_id,
                    'system_id' => SystemHelper::getSystemId(AccessibleTypeSystemCodeEnum::fromKey($attachmentFile->attachable_type)->value),
                    'action' => AccessActionTypeEnum::DELETE,
                    'accessible_type' => AccessibleTypeEnum::ATTACHMENT_FILE,
                    'accessible_id' => $attachmentFile->id,
                    'message' => $attachmentFile->file_name,
                    'access_at' => Carbon::now(),
                ]);
                $attachmentFile->delete();
                $result = true;
            }
        });
        return $result;
    }

    public function downloadAttachment(AttachmentFile $attachmentFile): bool|StreamedResponse
    {
        if (Storage::disk('s3')->exists($attachmentFile->file_path)) {
            return Storage::disk('s3')->download($attachmentFile->file_path);
        }
        return false;
    }

    public function validateModel(Collection $attachmentFiles): ?Model
    {
        /**
         * @var AttachmentFileData $attachmentFile
         */
        $attachmentFile = $attachmentFiles->count() ? $attachmentFiles->first() : null;
        if (!$attachmentFile) {
            return null;
        }

        return match ($attachmentFile->attachableType) {
            AttachableTypeEnum::EMPLOYEE => Employee::query()->find($attachmentFile->attachableId),
            AttachableTypeEnum::COMPANY => Company::query()->find($attachmentFile->attachableId),
            AttachableTypeEnum::SITE => Site::query()->find($attachmentFile->attachableId),
            AttachableTypeEnum::DEPARTMENT => Department::query()->find($attachmentFile->attachableId),
            AttachableTypeEnum::DIVISION => Division::query()->find($attachmentFile->attachableId),
            AttachableTypeEnum::NEGOTIATION => Negotiation::query()->find($attachmentFile->attachableId),
            AttachableTypeEnum::PRODUCT => Product::query()->find($attachmentFile->attachableId),
            AttachableTypeEnum::FACILITY => Facility::query()->find($attachmentFile->attachableId),
            AttachableTypeEnum::BASIC_CONTRACT => BasicContract::query()->find($attachmentFile->attachableId),
            AttachableTypeEnum::INDIVIDUAL_CONTRACT => IndividualContract::query()->find($attachmentFile->attachableId),
            default => null,
        };
    }

    public function getFiles(Collection $attachmentFiles): Collection
    {
        /**
         * @var AttachmentFile $attachmentFile
         */
        $attachmentFile = $attachmentFiles->count() ? $attachmentFiles->first() : null;
        if (!$attachmentFile) {
            return $attachmentFiles;
        }

        $requestQuery = (new AttachmentFileAllQuery(request()))->setFilterParam(
            new AttachmentQueryParam($attachmentFile->attachable_type, $attachmentFile->attachable_id));

        return $this->attachmentFileRepository->findByFilters($requestQuery);
    }

    public function getAvatarUser(): AttachmentFile|null
    {
        $requestQuery = (new AttachmentFileAllQuery(request()))->filterAvatar(
            new AttachmentQueryAvatarParam(AttachableTypeEnum::EMPLOYEE, Auth::user()->employee_id));
        $symbolFiles = $this->attachmentFileRepository->findByFilters($requestQuery);
        return $symbolFiles?->first();
    }
}
