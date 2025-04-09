<?php

namespace App\Repositories\FAQ;

use App\Enums\Common\UseFlagEnum;
use App\Helpers\FileHelper;
use App\Models\AnswerFile;
use App\Models\Display;
use App\Models\Question;
use App\Repositories\FAQ\Filter\FilterNotHasQuestionId;
use App\Repositories\FAQ\Sort\SortByCode;
use App\Repositories\FAQ\Sort\SortByDisplayOrder;
use App\Repositories\FAQ\Sort\SortByTitle;
use App\Trait\HasPagination;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Validator\Exceptions\ValidatorException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\QueryBuilder;
use Throwable;

class QuestionRepository extends BaseRepository implements IQuestionRepository
{
    use HasPagination;

    public function model(): string
    {
        return Question::class;
    }

    protected string $defaultSort = 'id';

    protected array $allowedFilters = [
    ];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('display_id'),
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
        'updated_at',
    ];

    protected function allowedCustomSorts(): array
    {
        return [
            AllowedSort::custom('code', new SortByCode())->defaultDirection(SortDirection::DESCENDING),
            AllowedSort::custom('title', new SortByTitle())->defaultDirection(SortDirection::DESCENDING),
            AllowedSort::custom('display_order', new SortByDisplayOrder())->defaultDirection(SortDirection::DESCENDING),
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
            ->select(Question::$selectProps);
    }

    public function getList(Display $display): Collection
    {
        return $this->filters()
            ->where('display_id', $display->id)
            ->with(['similarFaq1', 'similarFaq2', 'similarFaq3'])
            ->defaultSort(AllowedSort::custom('code', new SortByCode()))
            ->get();
    }

    public function showDetail(Question $detail): Question
    {
        return $detail->load(['createdBy', 'updatedBy', 'display.system', 'similarFaq1', 'similarFaq2', 'similarFaq3']);
    }

    public function getAnswersByQuestion(Question $question): Question
    {
        return $question->load(['answerTexts', 'answerFiles', 'answerFiles.attachmentFile']);
    }

    /**
     * @throws Throwable
     */
    public function deleteQuestion(Question $question): void
    {
        DB::transaction(function () use ($question) {
            $question->answerFiles?->each(function (AnswerFile $answerFile) {
                $answerFile->attachmentFile && FileHelper::deleteAnswerFileS3($answerFile->attachmentFile);
            });
            $this->delete($question->id);
        });
    }

    public function checkExistedSimilarQuestion(Question $question): int
    {
        return QueryBuilder::for($this->model())
            ->where('similar_faq_1_id', $question->id)
            ->orWhere('similar_faq_2_id', $question->id)
            ->orWhere('similar_faq_3_id', $question->id)
            ->count('id');
    }

    /**
     * @throws ValidatorException
     */
    public function createQuestion(array $dataInsert): Question
    {
        $question = $this->create($dataInsert);
        return $this->showDetail($question);
    }

    /**
     * @throws ValidatorException
     */
    public function updateQuestion(array $dataUpdate, Question $question): Question
    {
        $question = $this->update($dataUpdate, $question->id);
        return $this->showDetail($question);
    }

    public function getQuestionClassification(): Collection
    {
        return QueryBuilder::for($this->model())->select('classification')
            ->distinct('classification')
            ->where('use_classification', UseFlagEnum::USE)
            ->orderBy('classification')
            ->get();
    }

    public function getSimilarQuestions(): Collection
    {
        return QueryBuilder::for($this->model())
            ->allowedFilters(
                AllowedFilter::custom('not_question_id', new FilterNotHasQuestionId())
            )
            ->select([
                'snet_questions.id',
                'snet_questions.code',
                'snet_questions.classification',
                'snet_questions.title',
                'snet_questions.use_classification',
                'snet_questions.display_order',
            ])
            ->where('use_classification', UseFlagEnum::USE)
            ->orderBy('display_order')
            ->get();
    }
}
