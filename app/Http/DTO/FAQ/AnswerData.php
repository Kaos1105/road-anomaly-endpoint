<?php

declare(strict_types=1);

namespace App\Http\DTO\FAQ;

use App\Enums\FAQ\AnswerFileEnum;
use App\Enums\FAQ\AnswerTypeEnum;
use App\Helpers\FileHelper;
use App\Http\DTO\AttachmentFile\AttachmentFileData;
use App\Models\AnswerFile;
use App\Models\AnswerText;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class AnswerData extends Data
{
    public function __construct(
        public int                 $id,
        public int                 $displayOrder,
        public string              $typeAnswer,
        public int                 $answerId,
        public ?string             $answerContent,
        public ?string             $filePath,
        public ?string             $fileName,
        public ?int                $widthSize,
        public ?AttachmentFileData $attachmentFile,
    )
    {

    }

    public static function mapCollection(?Collection $answerTexts, ?Collection $answerFiles): Collection
    {
        $answerTexts = $answerTexts?->map(function (AnswerText $answerText) {
            return AnswerData::from([
                ...$answerText->toArray(),
                'type_answer' => AnswerTypeEnum::TEXT,
                'answer_id' => $answerText->id,
            ]);

        }) ?? collect();
        $answerFiles = $answerFiles?->map(function (AnswerFile $answerFile) {
            $attachment = $answerFile->attachmentFile;
            return AnswerData::from([
                ...$answerFile->toArray(),
                'type_answer' => AnswerTypeEnum::FILE,
                'file_path' => $attachment ?
                    FileHelper::temporaryUrl($attachment->file_path, AnswerFileEnum::SHOW_TIME) : null,
                'file_name' => $attachment?->file_name,
                'answer_id' => $answerFile->id,
                'attachment_file' => $attachment ? AttachmentFileData::from([
                    ...$attachment->toArray(),
                    'file_path' => FileHelper::temporaryUrl($attachment->file_path, AnswerFileEnum::SHOW_TIME),
                    'file_name' => $attachment?->file_name
                ]) : null
            ]);
        }) ?? collect();
        if ($answerTexts->count() == 0 && $answerFiles->count() == 0) {
            return collect();
        }

        $answers = $answerTexts->count() > 0 ? $answerTexts->merge($answerFiles) : $answerFiles->merge($answerTexts);

        return $answers->sortBy(function (AnswerData $answer) {
            return $answer->displayOrder;
        })->values()->map(function (AnswerData $answer, $index) {
            $answer->id = $index + 1;
            return $answer;
        });
    }
}
