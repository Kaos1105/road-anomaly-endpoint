<?php

namespace App\Services\FAQ;

use App\Enums\FAQ\AnswerTypeEnum;
use App\Helpers\FileHelper;
use App\Http\DTO\FAQ\AnswerInputData;
use App\Models\AnswerFile;
use App\Models\AnswerText;
use App\Repositories\FAQ\IAnswerFileRepository;
use App\Repositories\FAQ\IAnswerTextRepository;
use App\Repositories\FAQ\IQuestionRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

class AnswerService implements IAnswerService
{
    public function __construct(
        public IQuestionRepository   $questionRepository,
        public IAnswerTextRepository $answerTextRepository,
        public IAnswerFileRepository $answerFileRepository,
    )
    {
    }

    public function getNextDisplayOrder(int $questionId): int
    {
        $text = $this->answerTextRepository->getLastAnswerByQuestionId($questionId);
        $file = $this->answerFileRepository->getLastAnswerByQuestionId($questionId);
        $displayOrderText = $text->display_order ?? 0;
        $displayOrderFile = $file->display_order ?? 0;
        return max($displayOrderText, $displayOrderFile) + 1;
    }


    /**
     * @throws Throwable
     */
    public function deleteAnswer(int $questionId, int $answerDisplayOrder, int $answerId, string $answerType = AnswerTypeEnum::TEXT): void
    {
        DB::transaction(function () use ($questionId, $answerDisplayOrder, $answerId, $answerType) {
            if ($answerType == AnswerTypeEnum::FILE) {
                $answerFile = $this->answerFileRepository->getAnswerFile($answerId);
                $answerFile->attachmentFile && FileHelper::deleteAnswerFileS3($answerFile->attachmentFile);
                $this->answerFileRepository->delete($answerId);
            } else {
                $this->answerTextRepository->delete($answerId);
            }

            $texts = $this->answerTextRepository->getAnswerUpdateByQuestionId($questionId, $answerDisplayOrder);
            $texts?->each(function (AnswerText $answerText) {
                $newDisplay = $answerText->display_order - 1;
                $this->answerTextRepository->update(['display_order' => $newDisplay], $answerText->id);
            });

            $files = $this->answerFileRepository->getAnswerUpdateByQuestionId($questionId, $answerDisplayOrder);
            $files?->each(function (AnswerFile $answerFile) {
                $newDisplay = $answerFile->display_order - 1;
                $this->answerFileRepository->update(['display_order' => $newDisplay], $answerFile->id);
            });
        });
    }

    /**
     * @throws Throwable
     */
    public function updateDropDragAnswer(int $questionId, array $dataUpdate): void
    {
        $start = AnswerInputData::from($dataUpdate['answer_start']);
        $end = AnswerInputData::from($dataUpdate['answer_end']);

        if ($start->displayOrder < $end->displayOrder) {
            // Down
            $texts = $this->answerTextRepository->getAnswerUpdateByQuestionId($questionId, $start->displayOrder, $end->displayOrder);
            $updateAnswerTextStatement = $texts?->map(function (AnswerText $answerText) {
                $newDisplay = $answerText->display_order - 1;
                return " WHEN {$answerText->id} THEN {$newDisplay}";
            })->implode(' ');

            $files = $this->answerFileRepository->getAnswerUpdateByQuestionId($questionId, $start->displayOrder, $end->displayOrder);
            $updateAnswerFileStatement = $files?->map(function (AnswerFile $answerFile) {
                $newDisplay = $answerFile->display_order - 1;
                return " WHEN $answerFile->id THEN $newDisplay ";
            })->implode(' ');

        } else {
            // Up
            $texts = $this->answerTextRepository->getAnswerUpdateByQuestionId($questionId, $end->displayOrder - 1, $start->displayOrder - 1);
            $updateAnswerTextStatement = $texts?->map(function (AnswerText $answerText) {
                $newDisplay = $answerText->display_order + 1;
                return " WHEN {$answerText->id} THEN {$newDisplay} ";
            })->implode(' ');

            $files = $this->answerFileRepository->getAnswerUpdateByQuestionId($questionId, $end->displayOrder - 1, $start->displayOrder - 1);
            $updateAnswerFileStatement = $files?->map(function (AnswerFile $answerFile) {
                $newDisplay = $answerFile->display_order + 1;
                return " WHEN {$answerFile->id} THEN {$newDisplay} ";
            })->implode(' ');
        }

        $textIds = $texts?->pluck('id')->values();
        $filesIds = $files?->pluck('id')->values();

        $this->statementSwitchAnswers($start, $end, $updateAnswerTextStatement, $updateAnswerFileStatement, $textIds, $filesIds);

        DB::transaction(function () use ($start, $end, $updateAnswerTextStatement, $updateAnswerFileStatement, $textIds, $filesIds) {
            if ($textIds->count() > 0) {
                AnswerText::query()->whereIn('id', $textIds)->update([
                    'display_order' => DB::raw("CASE id " . $updateAnswerTextStatement . " END "),
                ]);
            }
            if ($filesIds->count() > 0) {
                AnswerFile::query()->whereIn('id', $filesIds)->update([
                    'display_order' => DB::raw("CASE id " . $updateAnswerFileStatement . " END "),
                ]);
            }
        });
    }

    private function statementSwitchAnswers(AnswerInputData $first, AnswerInputData $second, string &$updateAnswerTextStatement, string &$updateAnswerFileStatement, Collection &$textIds, Collection &$filesIds): void
    {
        if ($first->typeAnswer == AnswerTypeEnum::TEXT) {
            $updateAnswerTextStatement .= " WHEN {$first->id} THEN {$second->displayOrder} ";
            $textIds[] = $first->id;
        } else {
            $updateAnswerFileStatement .= " WHEN {$first->id} THEN {$second->displayOrder} ";
            $filesIds[] = $first->id;
        }
    }
}
