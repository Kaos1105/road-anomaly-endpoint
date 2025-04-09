<?php

namespace App\Repositories\AttachmentFile;

use App\Models\AttachmentFile;
use App\Query\AttachmentFile\AttachmentFileAllQuery;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AttachmentFileRepository extends BaseRepository implements IAttachmentFileRepository
{
    public function model(): string
    {
        return AttachmentFile::class;
    }

    protected string $defaultSort = 'id';

    protected array $allowedFilters = [
        'attachable_id',
        'attachable_type',
    ];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
        ];
    }

    protected function allowedScopedFilters(): array
    {
        return [
        ];
    }

    protected function allowedCustomFilters(): array
    {
        return [
        ];
    }

    protected array $allowedSorts = [
        'file_name',
        'attachable_type',
    ];

    protected function allowedCustomSorts(): array
    {
        return [
        ];
    }

    protected array $allowedIncludes = [
    ];

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        //$this->pushCriteria(app(RequestCriteria::class));
    }

    protected function filters(): QueryBuilder
    {
        return QueryBuilder::for($this->model())
            ->allowedFilters([
                ...$this->allowedFilters,
                ...$this->allowedExactFilters(),
                ...$this->allowedScopedFilters(),
                ...$this->allowedCustomFilters(),
            ])
            ->allowedIncludes($this->allowedIncludes)
            ->allowedSorts([
                ...$this->allowedSorts,
                ...$this->allowedCustomSorts(),
            ])
            ->defaultSort($this->defaultSort)
            ->select(AttachmentFile::$selectProps);
    }

    public function findByFilters(AttachmentFileAllQuery $query): Collection
    {
        return $query->select(AttachmentFile::$selectProps)->get();
    }
}
