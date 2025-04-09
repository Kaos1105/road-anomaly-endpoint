<?php

namespace App\Services\Transfer;

use App\Enums\System\SystemCodeEnum;
use App\Helpers\SystemHelper;
use App\Models\Transfer;
use App\Repositories\Transfer\ITransferRepository;
use Illuminate\Database\Eloquent\Model;

readonly class TransferService implements ITransferService
{
    public function __construct(
        private ITransferRepository $transferRepository,
    )
    {
    }

    public function getRepo(): ITransferRepository
    {
        return $this->transferRepository;
    }
    public function showEmployee(Transfer $transfer): Transfer|Model|null
    {
        return $transfer->load('employee');
    }

    public function getChildNames(Transfer $transfer): ?string
    {
        $countRelation = $this->transferRepository->checkRelations($transfer);

        if ($countRelation->customer_count > 0) {
            return SystemHelper::getSystemName(SystemCodeEnum::SOCIAL);
        }
        return null;
    }

}
