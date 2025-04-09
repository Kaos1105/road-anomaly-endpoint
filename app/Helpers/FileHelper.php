<?php

namespace App\Helpers;

use App\Enums\AccessHistory\AccessActionTypeEnum;
use App\Enums\AccessHistory\AccessibleTypeEnum;
use App\Enums\AccessHistory\AccessibleTypeSystemCodeEnum;
use App\Enums\Common\AWSEnum;
use App\Http\DTO\AttachmentFile\AttachmentFileData;
use App\Models\AccessHistory;
use App\Models\AttachmentFile;
use BenSampo\Enum\Exceptions\InvalidEnumKeyException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileHelper
{
    public static function getRandTimeStr(): string
    {
        return time() . Str::random(4);
    }

    public static function uploadFileToS3(AttachmentFileData $attachmentFileData): string|bool
    {
        $environment = app()->environment();

        // Construct the file path
        $filePath = "{$environment}/{$attachmentFileData->attachableType}";
        $result = Storage::disk('s3')->put($filePath, $attachmentFileData->fileContent);

        // Upload the file to S3
        return $result ?: false;
    }

    public static function temporaryUrl(string $filePath, ?int $minutes): string
    {
        return Storage::disk('s3')->temporaryUrl($filePath, now()->addMinutes($minutes > 0 ? $minutes : AWSEnum::S3_EXPIRED_MINUTES));
    }


    public static function deleteAnswerFileS3(AttachmentFile $attachmentFile): bool
    {
        $result = Storage::disk('s3')->delete($attachmentFile->file_path);
        if ($result) {
            $attachmentFile->delete();
            return $result;
        }
        return $result;
    }

    /**
     * @throws InvalidEnumKeyException
     */
    public static function deleteAttachmentFiles(Collection $attachmentFiles, string $accessibleType): void
    {
        $accessHistories = [];
        $attachmentFiles->each(function (AttachmentFile $attachmentFile) use ($accessibleType, &$accessHistories) {
            $accessHistories[] = [
                'employee_id' => \Auth::user()->employee_id,
                'system_id' => SystemHelper::getSystemId(AccessibleTypeSystemCodeEnum::fromKey($accessibleType)->value),
                'action' => AccessActionTypeEnum::DELETE,
                'accessible_type' => AccessibleTypeEnum::ATTACHMENT_FILE,
                'accessible_id' => $attachmentFile->id,
                'message' => $attachmentFile->file_name,
                'access_at' => Carbon::now(),
            ];
            self::deleteAnswerFileS3($attachmentFile);
        });
        if (!empty($accessHistories)) {
            AccessHistory::insert($accessHistories);
        }
    }
}
