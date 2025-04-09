<?php

namespace App\Services\Display;

use App\Models\Display;
use App\Repositories\Display\IDisplayRepository;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

interface IDisplayService
{
    public function getRepo(): IDisplayRepository;

    public function getList(): Collection|EloquentCollection;

    public function getListQuestions(): Collection|EloquentCollection;

    public function getChildNames(Display $display): ?string;

    public function deleteRecord(Display $display): void;

    public function exportData(): EloquentCollection;

    public function getDisplaysForDropdown(int $systemId): Collection;
}
