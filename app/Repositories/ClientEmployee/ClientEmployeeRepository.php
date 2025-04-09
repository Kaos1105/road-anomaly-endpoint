<?php

namespace App\Repositories\ClientEmployee;

use App\Models\ClientEmployee;
use App\Models\ClientSite;
use App\Models\Site;
use App\Repositories\AccessPermission\AccessPermissionRepository;
use App\Trait\HasPagination;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ClientEmployeeRepository extends BaseRepository implements IClientEmployeeRepository
{
    use HasPagination;

    public function model(): string
    {
        return ClientEmployee::class;
    }

    protected string $defaultSort = 'display_order';

    protected array $allowedFilters = [
    ];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('use_classification'),
        ];
    }

    protected function allowedScopedFilters(): array
    {
        return [
        ];
    }

    protected function allowedCustomFilters(): array
    {
        return [
        ];
    }

    protected array $allowedSorts = [
        'updated_at'
    ];

    protected function allowedCustomSorts(): array
    {
        return [
        ];
    }

    protected array $allowedIncludes = [
    ];

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
    }

    protected function filters(): QueryBuilder
    {
        return QueryBuilder::for($this->model())
            ->allowedFilters([
                ...$this->allowedFilters,
                ...$this->allowedExactFilters(),
                ...$this->allowedScopedFilters(),
                ...$this->allowedCustomFilters(),
            ])
            ->allowedIncludes($this->allowedIncludes)
            ->allowedSorts([
                ...$this->allowedSorts,
                ...$this->allowedCustomSorts(),
            ])
            ->defaultSort($this->defaultSort)
            ->select(Site::$selectProps);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->filters()
            ->paginate($this->getPerPage());
    }

    public function findAll(ClientSite $clientSite): Collection|array
    {
        return QueryBuilder::for(ClientEmployee::class)
            ->where('client_site_id', $clientSite->id)
            ->with('employee', function (BelongsTo $employeeQuery) use ($clientSite) {
                $employeeQuery->with('transfers', function (HasMany $transferQuery) use ($clientSite) {
                    $now = Carbon::now();
                    AccessPermissionRepository::filterTransferByDateConditions($transferQuery->getQuery(), $now);
                    $transferQuery->where('site_id', $clientSite->site_id)->with(['site', 'department', 'division'])->orderBy('start_date');
                });
            })->orderBy($this->defaultSort)
            ->get();
    }

    public function getDetail(ClientEmployee $clientEmployee): Model|QueryBuilder
    {
        return $clientEmployee;
    }


    public function checkRelations(ClientEmployee $clientEmployee): Model|Site
    {
        return QueryBuilder::for($this->model())
            ->withCount('negotiable')
            ->find($clientEmployee->id);
    }

    public function findByQuery(QueryBuilder $query): Collection|array
    {
        return $query->select(ClientEmployee::$selectProps)
            ->with('employee')
            ->orderBy('display_order')
            ->get();
    }
}
