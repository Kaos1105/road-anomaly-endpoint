<?php

namespace App\Repositories\DeviceInformation;

use App\Models\DeviceInformation;
use App\Trait\HasFavorite;
use App\Trait\HasPagination;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class DeviceInformationRepository extends BaseRepository implements IDeviceInformationRepository
{
    use HasPagination, HasFavorite;

    public function model(): string
    {
        return DeviceInformation::class;
    }

    protected string $defaultSort = '-updated_at';

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
//            ->allowedSorts([
//                ...$this->allowedSorts,
//                ...$this->allowedCustomSorts(),
//            ])
            ->defaultSort($this->defaultSort)
            ->select(DeviceInformation::$selectProps);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->filters()->paginate($this->getPerPage());
    }

    public function findAll(int $employeeId): Collection|array
    {
        return $this->filters()->where('employee_id', $employeeId)->defaultSort($this->defaultSort)->get();
    }

    public function findByDeviceName(int $employeeId, string $deviceName): DeviceInformation|null
    {
        return DeviceInformation::where([
            'employee_id' => $employeeId,
            'name' => $deviceName,
        ])->first();
    }

}
