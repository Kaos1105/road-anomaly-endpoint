<?php

namespace App\Repositories\FAQ;

use App\Models\AnswerText;
use App\Trait\HasPagination;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AnswerTextRepository extends BaseRepository implements IAnswerTextRepository
{
    use HasPagination;

    public function model(): string
    {
        return AnswerText::class;
    }

    protected string $defaultSort = 'id';

    protected array $allowedFilters = [
    ];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('question_id'),
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
    ];

    protected function allowedCustomSorts(): array
    {
        return [];
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
            ->select(AnswerText::$selectProps);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->filters()->paginate($this->getPerPage());
    }

    public function getList(): Collection
    {
        return $this->filters()->get();
    }

    public function showDetail(int $answerTextId): AnswerText|QueryBuilder|null
    {
        return QueryBuilder::for($this->model())->findOrFail($answerTextId);
    }

    public function getLastAnswerByQuestionId(int $questionId): AnswerText|QueryBuilder|null
    {
        return QueryBuilder::for($this->model())->where('question_id', $questionId)
            ->orderByDesc('display_order')
            ->select(AnswerText::$selectProps)->first();
    }

    public function getAnswerUpdateByQuestionId(int $questionId, int $start, int $end = null): Collection|null
    {
        $query = QueryBuilder::for($this->model())->select(AnswerText::$selectProps)
            ->where('question_id', $questionId)
            ->where('display_order', '>', $start);
        if($end) {
            $query = $query->where('display_order', '<=', $end);
        }
        return $query->get();
    }
}
