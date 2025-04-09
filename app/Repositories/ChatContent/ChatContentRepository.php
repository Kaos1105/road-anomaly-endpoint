<?php

namespace App\Repositories\ChatContent;

use App\Enums\Chat\ChatClassification;
use App\Enums\Employee\AvatarFileEnum;
use App\Models\ChatContent;
use App\Models\ChatThread;
use App\Trait\HasPagination;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Support\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ChatContentRepository extends BaseRepository implements IChatContentRepository
{
    use HasPagination;

    public function model(): string
    {
        return ChatContent::class;
    }

    protected string $defaultSort = '-id';

    protected array $allowedFilters = [
    ];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('chat_thread_id'),
            AllowedFilter::exact('chat_classification'),
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
        'chat_at'
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

    public function getPaginateList(): CursorPaginator
    {
        return $this->filters()->with(['employee' => function (BelongsTo $employeeQuery) {
            $employeeQuery->with(['attachmentFiles' => function (MorphMany $attachmentFileQuery) {
                $attachmentFileQuery->where('file_name', 'LIKE', AvatarFileEnum::FILE_NAME . '%');
            }]);
        }, 'attachmentFiles'])
            ->cursorPaginate($this->getCursorPerPage());
    }

    public function getPaginatedCursor(): CursorPaginator
    {
        return QueryBuilder::for($this->model())->defaultSort($this->defaultSort)
            ->select('id')->cursorPaginate($this->getCursorPerPage());
    }

    public function createChatContent(array $chatContent): ChatContent|null
    {
        $chatContent = new ChatContent($chatContent);
        $chatThread = ChatThread::find($chatContent->chat_thread_id);

        if (!$chatThread) {
            if ($chatContent->chat_classification != ChatClassification::USER_CONTENT) {
                return null;
            }
            try {
                DB::transaction((function () use ($chatContent) {
                    $chatThread = ChatThread::create(
                        [
                            'creator_id' => $chatContent->employee_id
                        ]
                    );
                    $chatThread->chatContents()->save($chatContent);
                }));
            } catch (\Throwable $e) {
                return null;
            }
        } else {
            $chatContent->save();
        }

        return $chatContent;
    }

    public function getChatContentDetail(ChatContent $chatContent): ChatContent
    {
        return $chatContent->fresh()->load(['employee' => function (BelongsTo $employeeQuery) {
            $employeeQuery->with(['attachmentFiles' => function (MorphMany $attachmentFileQuery) {
                $attachmentFileQuery->where('file_name', 'LIKE', AvatarFileEnum::FILE_NAME . '%');
            }]);
        }, 'attachmentFiles']);
    }

}
