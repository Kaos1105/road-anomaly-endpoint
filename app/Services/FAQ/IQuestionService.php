<?php

namespace App\Services\FAQ;

use App\Models\Display;
use App\Models\Question;
use App\Repositories\FAQ\IQuestionRepository;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

interface IQuestionService
{
    public function getRepo(): IQuestionRepository;

    public function getList(Display $display = null): Collection|EloquentCollection;

    public function getPermissionQuestion(Question $question): Collection|null;

}
