<?php

namespace App\Trait;

use App\Enums\AccessPermission\Permission1FlagEnum;
use App\Enums\System\SystemCodeEnum;
use App\Models\AccessPermission;
use App\Models\Content;
use Carbon\Carbon;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

trait HasPermission
{
    public function accessibleSystemBuilder(Builder $query, Carbon $today): Builder
    {
        return $query->where('permission_1', '!=', Permission1FlagEnum::UN_AUTHORIZED_USER)
            ->where(function (Builder $query) use ($today) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', $today);
            })
            ->where(function (Builder $query) use ($today) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', $today);
            });
    }

    /**
     * @param string $systemCode
     * @return AccessPermission|null
     */
    public function getEmployeePermission(string $systemCode = SystemCodeEnum::SNET): AccessPermission|null
    {
        $systemCondition = function (Builder $system) use ($systemCode) {
            $system->where('code', $systemCode);
        };
        return $this->getPermission($systemCondition);
    }

    public function getPermissionBySystemId(?int $systemId): AccessPermission|null
    {
        $systemCondition = function (Builder $system) use ($systemId) {
            $system->where('id', $systemId);
        };
        return $this->getPermission($systemCondition);
    }

    public function getPermission(Closure $systemCondition): AccessPermission|null
    {
        $user = \Auth::user();
        $today = Carbon::now()->startOfDay();
        $query = AccessPermission::where([
            'employee_id' => $user->employee_id,
        ])->whereHas('system', $systemCondition);

        return $this->accessibleSystemBuilder($query, $today)->get(AccessPermission::$selectProps)->first();
    }

    public function getAllPermission(int $systemId = null): Collection|null
    {
        $user = \Auth::user();
        $today = Carbon::now()->startOfDay();
        $query = AccessPermission::where('employee_id', $user->employee_id);
        if ($systemId) {
            $query = $query->where('system_id', $systemId);
        }

        return $this->accessibleSystemBuilder($query, $today)->get(AccessPermission::$selectProps);
    }

    public function getPermissionsBySystems(array $systemIds = null): Collection|null
    {
        $user = \Auth::user();
        $today = Carbon::now()->startOfDay();
        $query = AccessPermission::where('employee_id', $user->employee_id);
        if ($systemIds) {
            $query = $query->whereIn('system_id', $systemIds);
        }

        return $this->accessibleSystemBuilder($query, $today)->get(AccessPermission::$selectProps);
    }

    public function getScreenContent(?string $screenCode, ?string $contentNo): Content|null
    {
        if (empty($screenCode) || empty($contentNo)) {
            return null;
        }

        return Content::where([
            'no' => $contentNo,
        ])->whereHas('display', function (Builder $displayQuery) use ($screenCode) {
            $displayQuery->where('code', $screenCode);
        })->first();
    }
}
