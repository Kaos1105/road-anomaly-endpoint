<?php

namespace App\Repositories\AttachmentFile\Filter;

use App\Enums\Employee\AvatarFileEnum;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByFileName implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        if($value = AvatarFileEnum::FILE_NAME) {
            return $query->where('file_name', 'LIKE', $value . '%') ;
        } else {
            return $query->where('.file_name', 'LIKE', '%' . $value . '%');
        }

    }
}
