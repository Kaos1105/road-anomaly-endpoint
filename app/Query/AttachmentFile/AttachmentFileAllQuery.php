<?php

namespace App\Query\AttachmentFile;

use App\Http\DTO\AttachmentFile\AttachmentQueryAvatarParam;
use App\Http\DTO\AttachmentFile\AttachmentQueryParam;
use App\Models\AttachmentFile;
use App\Repositories\AttachmentFile\Filter\FilterByFileName;
use App\Trait\HasFilter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AttachmentFileAllQuery extends QueryBuilder
{
    use HasFilter;

    public function __construct(Request $request)
    {
        $query = AttachmentFile::query();
        parent::__construct($query, $request);
        $this->allowedFilters([
            AllowedFilter::exact('attachable_type'),
            AllowedFilter::exact('attachable_id'),
            AllowedFilter::custom('file_name', new FilterByFileName())
        ])->orderBy('created_at');
    }

    public function setFilterParam(AttachmentQueryParam $param): static
    {
        $paramArr = $param->toArray();
        $this->allowedFilters->each(function (AllowedFilter $filter) use ($paramArr) {
            $this->setParamValue($filter, $paramArr);
        });

        return $this;
    }

    public function filterAvatar(AttachmentQueryAvatarParam $param): static
    {
        $paramArr = $param->toArray();
        $this->allowedFilters->each(function (AllowedFilter $filter) use ($paramArr) {
            $this->setParamValue($filter, $paramArr);
        });
        return $this;
    }
}
