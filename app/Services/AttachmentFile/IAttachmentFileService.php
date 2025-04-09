<?php

namespace App\Services\AttachmentFile;

use App\Models\AttachmentFile;
use App\Repositories\AttachmentFile\IAttachmentFileRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;

interface IAttachmentFileService
{
    public function getRepo(): IAttachmentFileRepository;

    public function createAttachments(Collection $attachmentFiles): Collection;
    public function validateModel(Collection $attachmentFiles): ?Model;
    public function deleteAttachment(AttachmentFile $attachmentFile): bool;
    public function downloadAttachment(AttachmentFile $attachmentFile): StreamedResponse|bool;
    public function getFiles(Collection $attachmentFiles): Collection;
    public function getAvatarUser(): AttachmentFile|null;
}
