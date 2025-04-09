<?php

namespace App\Http\Controllers\SNET;

use App\Http\Controllers\Controller;
use App\Http\DTO\FAQ\AnswerData;
use App\Http\DTO\ResponseData;
use App\Http\Requests\FAQ\UpdateDisplayOrderAnswersRequest;
use App\Http\Requests\FAQ\UpsertQuestionRequest;
use App\Http\Resources\Display\ScreenQuestionItemResource;
use App\Http\Resources\FAQ\QuestionClassificationResource;
use App\Http\Resources\FAQ\QuestionDetailResource;
use App\Http\Resources\FAQ\SimilarQuestionResource;
use App\Models\Question;
use App\Services\Display\IDisplayService;
use App\Services\FAQ\IAnswerService;
use App\Services\FAQ\IQuestionService;

class QuestionController extends Controller
{
    public function __construct(
        private readonly IQuestionService $questionService,
        private readonly IAnswerService   $answerService,
        private readonly IDisplayService  $displayService,
    )
    {
    }

    public function index(): ResponseData
    {
        $result = $this->displayService->getListQuestions();
        return $this->httpOk(ScreenQuestionItemResource::collection($result));
    }

    public function show(Question $question): ResponseData
    {
        $detail = $this->questionService->getRepo()->showDetail($question);
        $permissionSimilar = $this->questionService->getPermissionQuestion($detail);
        return $this->httpOk(QuestionDetailResource::make($detail)->setParams($permissionSimilar));
    }

    public function store(UpsertQuestionRequest $request): ResponseData
    {
        $data = $request->validated();
        $question = $this->questionService->getRepo()->createQuestion($data);
        $permissionSimilar = $this->questionService->getPermissionQuestion($question);
        return $this->httpOk(QuestionDetailResource::make($question)->setParams($permissionSimilar));
    }

    public function update(UpsertQuestionRequest $request, Question $question): ResponseData
    {
        $data = $request->validated();
        $detail = $this->questionService->getRepo()->updateQuestion($data, $question);
        $permissionSimilar = $this->questionService->getPermissionQuestion($detail);
        return $this->httpOk(QuestionDetailResource::make($detail)->setParams($permissionSimilar));
    }

    public function destroy(Question $question): ResponseData
    {
        $existSimilar = $this->questionService->getRepo()->checkExistedSimilarQuestion($question);
        if ($existSimilar > 0) {
            return $this->httpBadRequest(msg: __('errors.can_not_delete_fqa'));
        }
        $this->questionService->getRepo()->deleteQuestion($question);
        return $this->httpNoContent();
    }

    public function getAnswers(Question $question): ResponseData
    {
        $result = $this->questionService->getRepo()->getAnswersByQuestion($question);
        return $this->httpOk(AnswerData::mapCollection($result->answerTexts, $result->answerFiles)->toArray());
    }

    public function dropdownQuestionClassification(): ResponseData
    {
        $questionClassification = $this->questionService->getRepo()->getQuestionClassification();
        return $this->httpOk(QuestionClassificationResource::collection($questionClassification));
    }

    public function dropdownSimilarQuestion(): ResponseData
    {
        $questionClassification = $this->questionService->getRepo()->getSimilarQuestions();
        return $this->httpOk(SimilarQuestionResource::collection($questionClassification));
    }


    public function changeDisplayOrderAnswer(UpdateDisplayOrderAnswersRequest $request, Question $question): ResponseData
    {
        $data = $request->validated();
        $this->answerService->updateDropDragAnswer($question->id, $data);
        $result = $this->questionService->getRepo()->getAnswersByQuestion($question);
        return $this->httpOk(AnswerData::mapCollection($result->answerTexts, $result->answerFiles)->toArray());
    }
}
