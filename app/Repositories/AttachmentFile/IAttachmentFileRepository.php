<?php

namespace App\Repositories\AttachmentFile;

use App\Query\AttachmentFile\AttachmentFileAllQuery;
use Prettus\Repository\Contracts\RepositoryInterface;

interface IAttachmentFileRepository extends RepositoryInterface
{
    public function findByFilters(AttachmentFileAllQuery $query): \Illuminate\Support\Collection;
}
