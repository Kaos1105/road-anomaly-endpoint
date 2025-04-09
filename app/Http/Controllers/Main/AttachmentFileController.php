<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\DTO\AttachmentFile\AttachmentFileData;
use App\Http\DTO\AttachmentFile\AvatarEmployeeData;
use App\Http\DTO\AttachmentFile\MultiFileData;
use App\Http\DTO\ResponseData;
use App\Http\Requests\Employee\UploadEmployeeFileRequest;
use App\Http\Resources\AttachmentFile\AttachmentCollectionResource;
use App\Models\AttachmentFile;
use App\Query\AttachmentFile\AttachmentFileAllQuery;
use App\Services\AttachmentFile\IAttachmentFileService;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AttachmentFileController extends Controller
{
    public function __construct(public IAttachmentFileService $attachmentFileService)
    {
    }

    public function getAttachableFiles(AttachmentFileAllQuery $query): ResponseData
    {
        $filter = request('filter');
        $attachments = collect();
        if ($filter && isset($filter['attachable_type']) && isset($filter['attachable_id'])) {
            $attachments = $this->attachmentFileService->getRepo()->findByFilters($query);
        }

        return $this->httpOk(new AttachmentCollectionResource($attachments));
    }

    public function uploadFile(UploadEmployeeFileRequest $request): ResponseData
    {
        $data = $request->validated();
        $files = AttachmentFileData::mapFromMultiFile(MultiFileData::from($data));

        $model = $this->attachmentFileService->validateModel($files);
        if (!$model) {
            return $this->httpNotFound([], trans('message.no_content'));
        }

        $attachments = $this->attachmentFileService->createAttachments($files);
        $result = $this->attachmentFileService->getFiles($attachments);

        if ($attachments->isEmpty()) {
            return $this->httpBadRequest();
        }
        return $this->httpOk(new AttachmentCollectionResource($result));
    }

    public function destroy(AttachmentFile $attachmentFile): ResponseData
    {
        $result = $this->attachmentFileService->deleteAttachment($attachmentFile);
        if (!$result) {
            return $this->httpNotFound();
        }

        return $this->httpNoContent();
    }

    public function download(AttachmentFile $attachmentFile): ResponseData|StreamedResponse
    {
        $result = $this->attachmentFileService->downloadAttachment($attachmentFile);
        if (!$result)
            return $this->httpNoContent();
        return $result;
    }

    public function getAvatar(): ResponseData
    {
        $data = $this->attachmentFileService->getAvatarUser();
        return $this->httpOk(AvatarEmployeeData::fromModel(\Auth::user()->employee, $data)->toArray());
    }
}
