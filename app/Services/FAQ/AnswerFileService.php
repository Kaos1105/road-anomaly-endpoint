<?php

namespace App\Services\FAQ;

use App\Enums\Common\AttachableTypeEnum;
use App\Helpers\FileHelper;
use App\Http\DTO\AnswerFile\UploadResultData;
use App\Http\DTO\AnswerFile\UpsertAnswerFileData;
use App\Http\DTO\AttachmentFile\AttachmentFileData;
use App\Models\AnswerFile;
use App\Models\AttachmentFile;
use App\Models\Login;
use App\Models\Question;
use App\Repositories\FAQ\IAnswerFileRepository;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Nette\Schema\ValidationException;
use Throwable;

class AnswerFileService implements IAnswerFileService
{
    public function __construct(
        public IAnswerFileRepository $answerFileRepository,
    )
    {
    }

    public function getRepo(): IAnswerFileRepository
    {
        return $this->answerFileRepository;
    }

    private function uploadAnswerFile(AnswerFile $answerFile, UploadedFile $file): UploadResultData
    {
        $attachmentFile = new AttachmentFileData(null, $answerFile->id, AttachableTypeEnum::ANSWER_FILE, null, null, $file);
        $uploadResult = FileHelper::uploadFileToS3($attachmentFile);

        /**
         * @var $login Login
         */
        $login = \Auth::user();
        $result = new AttachmentFile([
            'file_name' => $attachmentFile->fileContent->getClientOriginalName(),
            'file_path' => $uploadResult,
            'attachable_type' => $attachmentFile->attachableType,
            'attachable_id' => $attachmentFile->attachableId,
            'created_by' => $login->employee_id,
            'created_at' => Carbon::now(),
        ]);

        AttachmentFile::insert($result->toArray());
        return new UploadResultData($uploadResult, $attachmentFile->fileContent->getClientOriginalName());
    }

    /**
     * @throws Throwable
     */
    public function createAnswer(Question $question, UpsertAnswerFileData $dataInsert, int $displayOrder): AnswerFile|null
    {
        DB::transaction(function () use ($question, $dataInsert, $displayOrder) {
            $data = [
                ...$dataInsert->toArray(),
                'question_id' => $question->id,
                'display_order' => $displayOrder
            ];
            $answerFile = $this->answerFileRepository->create($data);

            if ($dataInsert->fileContent && count($dataInsert->fileContent)) {
                $upload = $this->uploadAnswerFile($answerFile, $dataInsert->fileContent[0]);
                if (!$upload->filePath) {
                    throw new ValidationException(__('errors.upload_file_fail'));
                }
            }
            return $answerFile;
        });
        return null;

    }

    /**
     * @throws Throwable
     */
    public function updateAnswer(UpsertAnswerFileData $dataUpdate, AnswerFile $answerFile): AnswerFile|null
    {
        DB::transaction(function () use ($dataUpdate, $answerFile) {
            if ($dataUpdate->fileContent && count($dataUpdate->fileContent)) {
                $answerFile->attachmentFile && FileHelper::deleteAnswerFileS3($answerFile->attachmentFile);
                $upload = $this->uploadAnswerFile($answerFile, $dataUpdate->fileContent[0]);
                if (!$upload->filePath) {
                    throw new ValidationException(__('errors.upload_file_fail'));
                }
            }
            return $this->answerFileRepository->update($dataUpdate->toArray(), $answerFile->id);
        });
        return null;
    }

}
