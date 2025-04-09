<?php

namespace App\Services\FAQ;

use App\Enums\FAQ\AnswerTypeEnum;

interface IAnswerService
{
    public function getNextDisplayOrder(int $questionId): int;

    public function deleteAnswer(int $questionId, int $answerDisplayOrder, int $answerId, string $answerType = AnswerTypeEnum::TEXT): void;

    public function updateDropDragAnswer(int $questionId, array $dataUpdate): void;
}
