<?php

namespace App\Repositories\FAQ;

use App\Models\Display;
use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;

interface IQuestionRepository extends RepositoryInterface
{
    public function showDetail(Question $detail): Question;

    public function getList(Display $display): Collection;

    public function getAnswersByQuestion(Question $question): Question;

    public function deleteQuestion(Question $question): void;

    public function checkExistedSimilarQuestion(Question $question): int;

    public function createQuestion(array $dataInsert): Question;

    public function updateQuestion(array $dataUpdate, Question $question): Question;

    public function getQuestionClassification(): Collection;

    public function getSimilarQuestions(): Collection;

}
