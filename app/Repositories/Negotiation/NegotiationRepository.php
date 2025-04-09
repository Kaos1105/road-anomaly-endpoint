<?php

namespace App\Repositories\Negotiation;

use App\Enums\Employee\AvatarFileEnum;
use App\Models\ClientEmployee;
use App\Models\ClientSite;
use App\Models\ManagementDepartment;
use App\Models\MyCompanyEmployee;
use App\Models\Negotiation;
use App\Repositories\Negotiation\Filter\FilterByManagementDepartmentId;
use App\Repositories\Negotiation\Filter\FilterByName;
use App\Repositories\Negotiation\Sort\SortByClientSiteDisplayOrder;
use App\Repositories\Negotiation\Sort\SortByDateTime;
use App\Trait\HasPagination;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Query\Builder as BuilderQuery;
use Illuminate\Http\Request;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Validator\Exceptions\ValidatorException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class NegotiationRepository extends BaseRepository implements INegotiationRepository
{
    use HasPagination;

    public function model(): string
    {
        return Negotiation::class;
    }

    protected string $defaultSort = 'id';

    protected array $allowedFilters = [
    ];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('client_site_id'),
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
            AllowedFilter::custom('search', new FilterByName()),
            AllowedFilter::custom('management_department_id', new FilterByManagementDepartmentId())
        ];
    }

    protected array $allowedSorts = [
        'updated_at'
    ];

    protected function allowedCustomSorts(): array
    {
        return [
            AllowedSort::custom('date_time', new SortByDateTime()),
            AllowedSort::custom('client_site', new SortByClientSiteDisplayOrder()),
        ];
    }

    protected array $allowedIncludes = [
    ];

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        //$this->pushCriteria(app(RequestCriteria::class));
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
            ->select(Negotiation::$selectProps);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->filters()
            ->with([
                'clientSite.site.company',
                'participants.negotiable' => function (MorphTo $morphTo) {
                    $morphTo->morphWith([
                        MyCompanyEmployee::class => ['employee'],
                        ClientEmployee::class => ['employee'],
                    ]);
                }
            ])
            ->addSelect(['client_site_display_order' => function (BuilderQuery $query) {
                $query->selectRaw('negotiation_client_sites.display_order')
                    ->from('negotiation_client_sites')
                    ->whereColumn('negotiation_negotiations.client_site_id', 'negotiation_client_sites.id');
            }])
            ->paginate($this->getPerPage());
    }

    public function findAllByClientSite(ClientSite $clientSite): Collection|array
    {
        return $this->filters()
            ->where('client_site_id', $clientSite->id)
            ->with([
                'participants.negotiable' => function (MorphTo $morphTo) {
                    $morphTo->morphWith([
                        MyCompanyEmployee::class => ['employee'],
                        ClientEmployee::class => ['employee'],
                    ]);
                }
            ])->get();
    }

    public function getCalendar(QueryBuilder $query): Collection|array
    {
        return $query->with([
            'site.company',
            'participants.negotiable' => function (MorphTo $morphTo) {
                $morphTo->morphWith([
                    MyCompanyEmployee::class => ['employee', 'employee.attachmentFiles' => function (MorphMany $query) {
                        $query->where('file_name', 'LIKE', AvatarFileEnum::FILE_NAME . '%');
                    }],
                ]);
            }
        ])
            ->orderBy('date_time')
            ->get();
    }

    public function showDetail(Negotiation $negotiation): Model|QueryBuilder
    {
        return $negotiation->load([
            'createdBy', 'updatedBy', 'commentBy',
            'clientSite.site.company',
            'participants.negotiable' => function (MorphTo $morphTo) {
                $morphTo->morphWith([
                    MyCompanyEmployee::class => ['employee'],
                    ClientEmployee::class => ['employee'],
                ]);
            }
        ]);
    }

    /**
     * @throws ValidatorException
     */
    public function updateLike(Negotiation $negotiation): Negotiation
    {
        return $this->update(['like_counter' => $negotiation->like_counter + 1], $negotiation->id);
    }

}
