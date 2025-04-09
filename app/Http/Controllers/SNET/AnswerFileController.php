<?php

namespace App\Http\Controllers\SNET;

use App\Enums\FAQ\AnswerTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\DTO\AnswerFile\UpsertAnswerFileData;
use App\Http\DTO\FAQ\AnswerData;
use App\Http\DTO\ResponseData;
use App\Http\Requests\FAQ\UpsertAnswerFileRequest;
use App\Models\AnswerFile;
use App\Models\Question;
use App\Services\FAQ\IAnswerFileService;
use App\Services\FAQ\IAnswerService;
use App\Services\FAQ\IQuestionService;

class AnswerFileController extends Controller
{
    public function __construct(
        private readonly IAnswerService     $answerService,
        private readonly IAnswerFileService $answerFileService,
        private readonly IQuestionService   $questionService,

    )
    {
    }

    public function store(UpsertAnswerFileRequest $request, Question $question): ResponseData
    {
        $data = $request->validated();
        $dataInsert = UpsertAnswerFileData::from($data);
        $nextDisplayOrder = $this->answerService->getNextDisplayOrder($question->id);
        $answer = $this->answerFileService->createAnswer($question, $dataInsert, $nextDisplayOrder);
        if (!$answer) {
            $this->httpBadRequest();
        }
        $result = $this->questionService->getRepo()->getAnswersByQuestion($question);

        return $this->httpOk(AnswerData::mapCollection($result->answerTexts, $result->answerFiles)->toArray());

    }

    public function update(UpsertAnswerFileRequest $request, Question $question, AnswerFile $answerFile): ResponseData
    {
        $data = $request->validated();
        $dataUpdate = UpsertAnswerFileData::from($data);
        $answer = $this->answerFileService->updateAnswer($dataUpdate, $answerFile);
        if (!$answer) {
            $this->httpBadRequest();
        }
        $result = $this->questionService->getRepo()->getAnswersByQuestion($question);

        return $this->httpOk(AnswerData::mapCollection($result->answerTexts, $result->answerFiles)->toArray());
    }

    public function destroy(Question $question, AnswerFile $answerFile): ResponseData
    {
        $this->answerService->deleteAnswer($answerFile->question_id, $answerFile->display_order, $answerFile->id, AnswerTypeEnum::FILE);
        $result = $this->questionService->getRepo()->getAnswersByQuestion($question);

        return $this->httpOk(AnswerData::mapCollection($result->answerTexts, $result->answerFiles)->toArray());
    }
}
