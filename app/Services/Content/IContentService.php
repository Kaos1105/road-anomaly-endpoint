<?php

namespace App\Services\Content;

use App\Repositories\Content\IContentRepository;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

interface IContentService
{
    public function getRepo(): IContentRepository;

    public function getList(): Collection|EloquentCollection;

    public function exportData(): EloquentCollection;

}
