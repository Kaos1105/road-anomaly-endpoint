<?php

namespace App\Services\FAQ;

use App\Models\AnswerText;
use App\Models\Question;
use App\Repositories\FAQ\IAnswerTextRepository;
use Illuminate\Http\Request;

class AnswerTextService implements IAnswerTextService
{
    public function __construct(
        public IAnswerTextRepository           $answerTextRepository,
    )
    {
    }

    public function getRepo(): IAnswerTextRepository{
        return $this->answerTextRepository;
    }


    public function createAnswer(Question $question, array $dataInsert, int $displayOrder): AnswerText
    {
        $dataInsert['display_order'] = $displayOrder;
        $dataInsert['question_id'] = $question->id;
        return $this->answerTextRepository->create($dataInsert);
    }

    public function deleteAnswer(Request $request)
    {

    }
}
