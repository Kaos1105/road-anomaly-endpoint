<?php

namespace App\Repositories\User;

use App\Http\DTO\Auth\LoginData;
use App\Models\User;
use App\Trait\HasPagination;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserRepository extends BaseRepository implements IUserRepository
{
    use HasPagination;

    public function model(): string
    {
        return User::class;
    }

    protected string $defaultSort = 'id';

    protected array $defaultSelect = [
        'users.id',
        'users.name',
        'users.email',
        'users.login_id',
        'users.use_classification',
        'users.statistic_classification',
    ];

    protected array $allowedFilters = [
        'use_classification',
        'statistic_classification',
    ];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
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
        'updated_at',
        'name',
        'email',
        'login_id',
        'use_classification',
        'statistic_classification',
        'id',
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
            ->select($this->defaultSelect);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->filters()->paginate($this->getPerPage());
    }

    public function findAll(): Collection|array
    {
        return $this->filters()->get();
    }

    public function showWithRelationship(string $id): Model|QueryBuilder
    {
        return QueryBuilder::for(User::whereId($id))
            ->allowedIncludes($this->allowedIncludes)
            ->select($this->defaultSelect)
            ->firstOrFail();
    }

    public function getDataLogin(LoginData $loginData): ?User
    {
        return User::where('login_id', $loginData->loginId)->first();
    }
}
