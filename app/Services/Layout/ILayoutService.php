<?php

namespace App\Services\Layout;

use App\Repositories\Layout\ILayoutRepository;
use Illuminate\Support\Collection;

interface ILayoutService
{
    public function getRepo(): ILayoutRepository;

    public function getLayoutDashboard(): Collection;

    public function dragDropLayoutDashboard(array $dataDragDrop): Collection;

}
