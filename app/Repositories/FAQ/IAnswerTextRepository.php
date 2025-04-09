<?php

namespace App\Repositories\FAQ;

use App\Models\AnswerText;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

interface IAnswerTextRepository extends RepositoryInterface
{
    public function showDetail(int $answerTextId): AnswerText|QueryBuilder|null;

    public function getPaginateList(): LengthAwarePaginator;

    public function getList(): Collection;

    public function getLastAnswerByQuestionId(int $questionId): AnswerText|QueryBuilder|null;

    public function getAnswerUpdateByQuestionId(int $questionId, int $start, int $end = null): Collection|null;

}
