<?php

namespace App\Services\FAQ;

use App\Http\DTO\AnswerFile\UpsertAnswerFileData;
use App\Models\AnswerFile;
use App\Models\Question;
use App\Repositories\FAQ\IAnswerFileRepository;

interface IAnswerFileService
{
    public function getRepo(): IAnswerFileRepository;

    public function createAnswer(Question $question, UpsertAnswerFileData $dataInsert, int $displayOrder): AnswerFile|null;

    public function updateAnswer(UpsertAnswerFileData $dataUpdate, AnswerFile $answerFile): AnswerFile|null;

}
