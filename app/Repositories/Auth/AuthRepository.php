<?php

namespace App\Repositories\Auth;

use App\Enums\AccessPermission\Permission1FlagEnum;
use App\Enums\System\SystemCodeEnum;
use App\Http\DTO\Auth\LoginData;
use App\Models\Login;
use App\Models\PersonalAccessToken;
use App\Trait\HasPagination;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AuthRepository extends BaseRepository implements IAuthRepository
{
    use HasPagination;

    public function model(): string
    {
        return Login::class;
    }

    protected string $defaultSort = 'id';

    protected array $allowedFilters = [
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
        'login_id',
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
            ->select(Login::$selectProps);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->filters()->paginate($this->getPerPage());
    }

    public function findAll(): Collection|array
    {
        return $this->filters()->get();
    }

    public function showWithRelationship(Login $login): Login
    {
        return $login->load(['employee']);
    }

    public function getUserLogin(LoginData $loginData): ?Login
    {
        $now = Carbon::now()->startOfDay();
        return Login::where('login_id', $loginData->loginId)
            ->with([
                'employee',
                'employee.accessPermissions' => function (HasMany $accessPermissionsQuery) use ($now) {
                    $accessPermissionsQuery->whereHas('system', function (Builder $systemQuery) {
                        $systemQuery->where('code', SystemCodeEnum::MAIN);
                    })
                        ->where('permission_1', '!=', Permission1FlagEnum::UN_AUTHORIZED_USER)
                        ->where(function ($query) use ($now) {
                            $query->whereNull('end_date')
                                ->orWhere('end_date', '>=', $now);
                        })
                        ->where(function ($query) use ($now) {
                            $query->whereNull('start_date')
                                ->orWhere('start_date', '<=', $now);
                        });
                }
            ])->first();
    }

    public function updateInactivityExpires(Login $login): bool
    {
        $token = PersonalAccessToken::where('tokenable_id', '=', $login->id)->orderByDesc('id')->first();
        return $token->update([
            'expired_inactivity_at' => Carbon::now()->addMinutes(config('sanctum.last_used_expiration'))
        ]);
    }

    public function updateLogin(Login $login, array $updateData): bool
    {
        return $login->update($updateData);
    }

    public function findLogin(int $employeeId): Login|null
    {
        return Login::where('employee_id', $employeeId)->with('employee')->first();
    }
}
