<?php

namespace App\Services\System;

use App\Models\System;
use App\Repositories\System\ISystemRepository;
use Illuminate\Database\Eloquent\Collection;

interface ISystemService
{
    public function getRepo(): ISystemRepository;

    public function getChildNames(System $system): ?string;

    public function checkSystemStopped(System $system): bool;

    public function createSystem(array $data): ?System;

    public function exportData(): Collection;
    

}
