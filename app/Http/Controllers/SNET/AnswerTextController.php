<?php

namespace App\Http\Controllers\SNET;

use App\Http\Controllers\Controller;
use App\Http\DTO\FAQ\AnswerData;
use App\Http\DTO\ResponseData;
use App\Http\Requests\FAQ\UpsertAnswerTextRequest;
use App\Models\AnswerText;
use App\Models\Question;
use App\Services\FAQ\IAnswerService;
use App\Services\FAQ\IAnswerTextService;
use App\Services\FAQ\IQuestionService;

class AnswerTextController extends Controller
{
    public function __construct(
        private readonly IAnswerService     $answerService,
        private readonly IAnswerTextService $answerTextService,
        private readonly IQuestionService   $questionService,
    )
    {
    }

    public function store(UpsertAnswerTextRequest $request, Question $question): ResponseData
    {
        $data = $request->validated();
        $nextDisplayOrder = $this->answerService->getNextDisplayOrder($question->id);
        $this->answerTextService->createAnswer($question, $data, $nextDisplayOrder);
        $result = $this->questionService->getRepo()->getAnswersByQuestion($question);

        return $this->httpOk(AnswerData::mapCollection($result->answerTexts, $result->answerFiles)->toArray());

    }

    public function update(UpsertAnswerTextRequest $request, Question $question, AnswerText $answerText): ResponseData
    {
        $data = $request->validated();
        $this->answerTextService->getRepo()->update($data, $answerText->id);
        $result = $this->questionService->getRepo()->getAnswersByQuestion($question);

        return $this->httpOk(AnswerData::mapCollection($result->answerTexts, $result->answerFiles)->toArray());
    }

    public function destroy(Question $question, AnswerText $answerText): ResponseData
    {
        $this->answerService->deleteAnswer($answerText->question_id, $answerText->display_order, $answerText->id);
        $result = $this->questionService->getRepo()->getAnswersByQuestion($question);

        return $this->httpOk(AnswerData::mapCollection($result->answerTexts, $result->answerFiles)->toArray());
    }

}
