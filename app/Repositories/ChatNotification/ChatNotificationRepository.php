<?php

namespace App\Repositories\ChatNotification;

use App\Enums\Chat\ReadClassification;
use App\Models\ChatContent;
use App\Models\ChatNotification;
use Illuminate\Support\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ChatNotificationRepository extends BaseRepository implements IChatNotificationRepository
{
    public function model(): string
    {
        return ChatNotification::class;
    }

    protected string $defaultSort = '-read_at';

    protected array $allowedFilters = [
    ];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('chat_thread_id'),
            AllowedFilter::exact('chat_content_id'),
            AllowedFilter::exact('employee_id'),
            AllowedFilter::exact('read_flag'),
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
        'id',
        'read_at'
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
            ->addSelect(ChatContent::$selectProps);
    }

    public function createClientSenderNotification(ChatContent $chatContent, Collection $employeeIds): bool
    {
        $insertingValues = $employeeIds->map((function (int $employeeId) use ($chatContent) {
            return [
                'chat_thread_id' => $chatContent->chat_thread_id,
                'chat_content_id' => $chatContent->id,
                'employee_id' => $employeeId,
                'read_flag' => ReadClassification::UNREAD
            ];
        }));
        return ChatNotification::insert($insertingValues->toArray());
    }
}
