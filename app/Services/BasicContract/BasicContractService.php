<?php

namespace App\Services\BasicContract;

use App\Enums\AccessHistory\AccessibleTypeEnum;
use App\Helpers\FileHelper;
use App\Models\BasicContract;
use App\Repositories\BasicContract\IBasicContractRepository;
use BenSampo\Enum\Exceptions\InvalidEnumKeyException;
use DB;
use Throwable;

readonly class BasicContractService implements IBasicContractService
{
    public function __construct(
        private IBasicContractRepository $basicContractRepository,
    )
    {
    }

    public function getRepo(): IBasicContractRepository
    {
        return $this->basicContractRepository;
    }

    public function getChildNames(BasicContract $basicContract): ?string
    {
        $countRelation = $this->basicContractRepository->checkRelations($basicContract);
        if ($countRelation->contract_workplaces_count > 0) {
            return __('attributes.contract_workplace.table');
        }
        if ($countRelation->individual_contracts_count > 0) {
            return __('attributes.individual_contract.table');
        }
        return null;
    }

    /**
     * @throws InvalidEnumKeyException
     * @throws Throwable
     */
    public function deleteRecord(BasicContract $basicContract): void
    {
        DB::transaction(function () use ($basicContract) {
            if (count($basicContract->attachmentFiles) > 0) {
                FileHelper::deleteAttachmentFiles($basicContract->attachmentFiles, AccessibleTypeEnum::BASIC_CONTRACT);
            }
            $basicContract->delete();
        });
    }


}
