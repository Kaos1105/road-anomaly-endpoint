<?php

namespace App\Repositories\FAQ;

use App\Models\AnswerFile;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

interface IAnswerFileRepository extends RepositoryInterface
{
    public function showDetail(AnswerFile $detail): AnswerFile;

    public function getAnswerFile(int $answerFileId): AnswerFile|null;

    public function getPaginateList(): LengthAwarePaginator;

    public function getList(): Collection;

    public function getLastAnswerByQuestionId(int $questionId): AnswerFile|QueryBuilder|null;

    public function getAnswerUpdateByQuestionId(int $questionId, int $start, int $end = null): Collection|null;

}
