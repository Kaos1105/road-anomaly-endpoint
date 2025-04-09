<?php

namespace App\Services\Site;

use App\Enums\AccessHistory\AccessibleTypeEnum;
use App\Enums\System\SystemCodeEnum;
use App\Helpers\FileHelper;
use App\Helpers\SystemHelper;
use App\Models\Site;
use App\Query\Site\SiteDropdownQuery;
use App\Repositories\Site\ISiteRepository;
use BenSampo\Enum\Exceptions\InvalidEnumKeyException;
use DB;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Throwable;

readonly class SiteService implements ISiteService
{
    public function __construct(
        private ISiteRepository $siteRepository,
    )
    {
    }

    public function getRepo(): ISiteRepository
    {
        return $this->siteRepository;
    }

    public function getChildNames(Site $site): ?string
    {
        $countRelation = $this->siteRepository->checkRelations($site);
        if ($countRelation->employees_count > 0) {
            return __('attributes.employee.table');
        }

        if ($countRelation->departments_count > 0) {
            return __('attributes.department.table');
        }

        if ($countRelation->suppliers_count > 0) {
            return SystemHelper::getSystemName(SystemCodeEnum::SOCIAL);
        }
        if (!empty($countRelation->clientSite)) {
            return SystemHelper::getSystemName(SystemCodeEnum::NEGOTIATION);
        }

        if ($countRelation->counterparty_count > 0 || $countRelation->our_site_contract_count > 0) {
            return SystemHelper::getSystemName(SystemCodeEnum::CONTRACT);
        }
        return null;
    }

    /**
     * @throws InvalidEnumKeyException
     * @throws Throwable
     */
    public function deleteRecord(Site $site): void
    {
        DB::transaction(function () use ($site) {
            if (count($site->attachmentFiles) > 0) {
                FileHelper::deleteAttachmentFiles($site->attachmentFiles, AccessibleTypeEnum::SITE);
            }
            $site->favorites()->delete();
            $site->delete();
        });
    }

    public function findByQuery(QueryBuilder $query): Collection|array
    {
        if (empty(request('filter')['company_id'])) {
            return collect();
        }
        return $this->siteRepository->findByQuery($query);
    }

    public function getSiteSupplier(SiteDropdownQuery $query): Collection|array
    {
        if (empty(request('filter')['company_id'])) {
            return collect();
        }
        return $this->siteRepository->getSiteStores($query);
    }

    public function getSiteContractDropdown(): Collection|array
    {
        $filter = request('filter');
        $isCounterparty = false;
        if ($filter && $filter['is_counterparty']) {
            $isCounterparty = true;
        }

        return $this->siteRepository->getSiteContractDropdown($isCounterparty);
    }
}
