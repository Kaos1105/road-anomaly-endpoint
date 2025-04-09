<?php

namespace App\Services\FAQ;

use App\Models\AnswerText;
use App\Models\Question;
use App\Repositories\FAQ\IAnswerTextRepository;
use Illuminate\Http\Request;

interface IAnswerTextService
{
    public function getRepo(): IAnswerTextRepository;
    public function createAnswer(Question $question, array $dataInsert, int $displayOrder): AnswerText;
    public function deleteAnswer(Request $request);
}
