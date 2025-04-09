<?php

namespace App\Repositories\ChatThread;

use App\Enums\Chat\ChatClassification;
use App\Enums\Chat\ReadClassification;
use App\Enums\Employee\AvatarFileEnum;
use App\Models\ChatContent;
use App\Models\ChatNotification;
use App\Models\ChatThread;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ChatThreadRepository extends BaseRepository implements IChatThreadRepository
{
    public function model(): string
    {
        return ChatThread::class;
    }

    protected string $defaultSort = '-id';

    protected array $allowedFilters = [
    ];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('creator_id'),
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
        'creator_id'
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
            ->addSelect(ChatThread::$selectProps);
    }

    public function getUserChatThread(): Employee
    {
        $employee = \Auth::user()->employee;
        return $employee->load(['chatThreads' => function (HasMany $chatThreadQuery) use ($employee) {
            $chatThreadQuery->with(['chatNotifications' => function (HasMany $notificationQuery) use ($employee) {
                $notificationQuery->where([
                    'employee_id' => $employee->id,
                    'read_flag' => ReadClassification::UNREAD
                ]);
            }]);
        }]);
    }

    public function markChatThreadAsRead(ChatThread $chatThread): int
    {
        $employee = \Auth::user()->employee;

        return $chatThread->chatNotifications()->where('employee_id', $employee->id)
            ->update(['read_flag' => ReadClassification::READ]);
    }

    public function getNotificationChatThreads(): Collection
    {
        return ChatThread::query()
            ->with([
                'creator',
                'chatNotifications' => function (HasMany $notificationQuery) {
                    $notificationQuery->with(['chatContent'])->where([
                        'read_flag' => ReadClassification::UNREAD,
                    ]);
                },
                'chatContents' => function (HasMany $contentQuery) {
                    $contentQuery->with(['employee'])
                        ->where('chat_classification', '=', ChatClassification::ADMIN_CONTENT)
                        ->orderByDesc('chat_at')->limit(1);
                },
            ])->select(ChatThread::$selectProps)
            ->addSelect([
                'last_chat_at' => self::chatContentQuery()->select('chat_at')
            ])->get();
    }

    public function getAllChatThreads(int $adminEmployeeId): Collection
    {
        return ChatThread::query()
            ->with([
                'creator',
                'chatNotifications' => function (HasMany $notificationQuery) use ($adminEmployeeId) {
                    $notificationQuery->where(function (Builder $query) use ($adminEmployeeId) {
                        $query->whereHas('chatContent', function (Builder $contentQuery) use ($adminEmployeeId) {
                            $contentQuery->where('chat_classification', '=', ChatClassification::ADMIN_CONTENT)
                                ->where('employee_id', '!=', $adminEmployeeId);
                        })->orWhereHas('chatContent', function (Builder $contentQuery) use ($adminEmployeeId) {
                            $contentQuery->where('chat_classification', '=', ChatClassification::USER_CONTENT);
                        });
                    })->where([
                        'read_flag' => ReadClassification::UNREAD,
                        'employee_id' => $adminEmployeeId
                    ]);
                },
                'chatContents' => function (HasMany $contentQuery) {
                    $contentQuery->with(['employee'])
                        ->where('chat_classification', '=', ChatClassification::ADMIN_CONTENT)
                        ->orderByDesc('chat_at')->limit(1);
                },
            ])
            ->select(ChatThread::$selectProps)
            ->addSelect([
                'last_chat_at' => self::chatContentQuery()->select('chat_at')
            ])->orderByDesc('last_chat_at')->get();
    }

    private function chatContentQuery(): Builder
    {
        return ChatContent::query()
            ->whereColumn('chat_thread_id', '=', 'snet_chat_threads.id')
            ->orderByDesc('chat_at')
            ->limit(1);
    }

    public function getDashboardUnreadThread(int $employeeId): Collection
    {
        $conditions = [
            'read_flag' => ReadClassification::UNREAD,
            'employee_id' => $employeeId
        ];
        return ChatThread::query()
            ->select(ChatThread::$selectProps)
            ->whereHas('chatNotifications', function (Builder $query) use ($conditions) {
                $query->where($conditions);
            })
            ->withCount(['chatNotifications' => function (Builder $query) use ($conditions) {
                $query->where($conditions);
            }])
            ->with([
                'creator',
                'creator.attachmentFiles' => function (MorphMany $query) {
                    $query->where('file_name', 'LIKE', AvatarFileEnum::FILE_NAME . '%');
                },
                'chatContents' => function ($query) {
                    $query->orderByDesc('chat_at')->limit(1);
                }
            ])
            ->addSelect(['chat_notification_id' =>
                ChatNotification::query()->select('snet_chat_notifications.id')
                    ->from('snet_chat_notifications')
                    ->where($conditions)
                    ->whereColumn('snet_chat_notifications.chat_thread_id', '=', 'snet_chat_threads.id')
                    ->orderByDesc('snet_chat_notifications.id')
                    ->limit(1)
            ])
            ->orderByDesc('chat_notification_id')
            ->get();
    }
}
