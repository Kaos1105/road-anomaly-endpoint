<?php

namespace App\Services\FAQ;

use App\Models\AccessPermission;
use App\Models\Display;
use App\Models\Question;
use App\Repositories\FAQ\IQuestionRepository;
use App\Trait\HasPermission;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class QuestionService implements IQuestionService
{
    use HasPermission;

    public function __construct(
        public IQuestionRepository $questionRepository,
    )
    {
    }

    public function getRepo(): IQuestionRepository
    {
        return $this->questionRepository;
    }

    public function getList(Display $display = null): Collection|EloquentCollection
    {
        if ($display) {
            return $this->questionRepository->getList($display);
        }
        return collect();
    }

    public function getPermissionQuestion(Question $question): Collection|null
    {
        $systemIds = array_unique([
            $question?->similarFaq1?->display?->system_id,
            $question?->similarFaq2?->display?->system_id,
            $question?->similarFaq3?->display?->system_id,
        ]);
        $permissionCollection = collect();
        if (!empty($systemIds)) {
            $permissionCollection = $this->getPermissionsBySystems($systemIds);
        }
        return $permissionCollection;
    }
}
