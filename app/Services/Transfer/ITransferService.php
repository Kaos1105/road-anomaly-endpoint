<?php

namespace App\Services\Transfer;

use App\Models\Transfer;
use App\Repositories\Transfer\ITransferRepository;
use Illuminate\Database\Eloquent\Model;

interface ITransferService
{
    public function getRepo(): ITransferRepository;

    public function showEmployee(Transfer $transfer): Transfer|Model|null;

    public function getChildNames(Transfer $transfer): ?string;
}
