<?php

namespace App\Services\ChatContent;

use App\Enums\Chat\ChatClassification;
use App\Enums\Common\AttachableTypeEnum;
use App\Enums\Employee\AvatarFileEnum;
use App\Enums\System\SystemCodeEnum;
use App\Helpers\FileHelper;
use App\Http\DTO\AttachmentFile\AttachmentFileData;
use App\Http\DTO\AttachmentFile\MultiFileData;
use App\Http\DTO\ChatContent\ChatContentWithCursorData;
use App\Models\AccessPermission;
use App\Models\AttachmentFile;
use App\Models\ChatContent;
use App\Models\Login;
use App\Repositories\AccessPermission\IAccessPermissionRepository;
use App\Repositories\ChatContent\IChatContentRepository;
use App\Repositories\ChatNotification\IChatNotificationRepository;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

class ChatContentService implements IChatContentService
{
    public function __construct(
        private IChatContentRepository      $chatContentRepository,
        private IAccessPermissionRepository $accessPermissionRepository,
        private IChatNotificationRepository $chatNotificationRepository,
    )
    {
    }

    public function getRepo(): IChatContentRepository
    {
        return $this->chatContentRepository;
    }

    protected function createChatContent(array $chatContentValue): ChatContent|null
    {
        $chatContent = null;
        try {
            DB::transaction(function () use ($chatContentValue, &$chatContent) {
                $chatContent = $this->chatContentRepository->createChatContent($chatContentValue);
                $notifications = $this->createChatNotification($chatContent);
                $attachmentFiles = $this->createChatFile($chatContent, $chatContentValue);
            });
        } catch (\Throwable $exception) {
            \Log::error($exception->getMessage());
        };

        return $this->chatContentRepository->getChatContentDetail($chatContent);
    }

    protected function createChatNotification(ChatContent $chatContent): bool
    {
        $accessPermissions = $this->accessPermissionRepository->getSystemAccessiblePermission(SystemCodeEnum::SNET);
        $employeeIds = $accessPermissions->map(fn(AccessPermission $permission) => $permission->employee_id)->unique()->values();

        $notifyEmployeeIds = $employeeIds;
        if ($chatContent->chat_classification == ChatClassification::ADMIN_CONTENT) {
            $chatThread = $chatContent->chatThread;
            $notifyEmployeeIds = $employeeIds->filter(function (int $employeeId) {
                return $employeeId !== Auth::user()->employee_id;
            })->push($chatThread->creator_id)->values();
        }

        return $this->chatNotificationRepository->createClientSenderNotification($chatContent, $notifyEmployeeIds);
    }

    /**
     * @throws \Throwable
     */
    protected function createChatFile(ChatContent $chatContent, array $chatContentValue): Collection
    {
        if (empty($chatContentValue['attachment_files'])) {
            return collect();
        }
        $files = AttachmentFileData::mapFromMultiFile(
            new MultiFileData($chatContent->id, AttachableTypeEnum::CHAT_CONTENT, $chatContentValue['attachment_files']));

        $result = collect();
        DB::transaction(function () use ($files, &$result) {
            $files->each(
                function (AttachmentFileData $attachmentFile) use (&$result, &$accessHistories) {
                    $uploadResult = FileHelper::uploadFileToS3($attachmentFile);
                    if ($uploadResult) {
                        /**
                         * @var $login Login
                         */
                        $login = Auth::user();

                        $attachment = new AttachmentFile([
                            'file_name' => $attachmentFile->fileContent->getClientOriginalName(),
                            'file_path' => $uploadResult,
                            'attachable_type' => $attachmentFile->attachableType,
                            'attachable_id' => $attachmentFile->attachableId,
                            'created_by' => $login->employee_id,
                            'created_at' => Carbon::now(),
                        ]);

                        $result->push($attachment);
                    }
                });
            AttachmentFile::insert($result->toArray());
        });
        return $result;
    }

    public function createChatContentEvent(array $chatContentValue): array
    {
        $chatContent = $this->createChatContent($chatContentValue);
        $paginationResult = $this->getRepo()->getPaginatedCursor();

        return ChatContentWithCursorData::mapping($chatContent, $paginationResult)->toArray();
    }


}
