<?php

namespace App\Services\IndividualContract;

use App\Enums\AccessHistory\AccessibleTypeEnum;
use App\Helpers\FileHelper;
use App\Models\IndividualContract;
use App\Repositories\IndividualContract\IIndividualContractRepository;
use BenSampo\Enum\Exceptions\InvalidEnumKeyException;
use DB;
use Throwable;

readonly class IndividualContractService implements IIndividualContractService
{
    public function __construct(
        private IIndividualContractRepository $basicContractRepository,
    )
    {
    }

    public function getRepo(): IIndividualContractRepository
    {
        return $this->basicContractRepository;
    }

    /**
     * @throws InvalidEnumKeyException
     * @throws Throwable
     */
    public function deleteRecord(IndividualContract $individualContract): void
    {
        DB::transaction(function () use ($individualContract) {
            if (count($individualContract->attachmentFiles) > 0) {
                FileHelper::deleteAttachmentFiles($individualContract->attachmentFiles, AccessibleTypeEnum::INDIVIDUAL_CONTRACT);
            }
            $individualContract->delete();
        });
    }


}
