<?php

namespace App\Trait;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

trait HasUserStamps
{
    public static function bootUserStamps(): void
    {
        static::creating(function ($model) {
            $userId = Auth::user()->employee_id;
            if ($userId && self::checkUserStampColumn($model->getTable(), 'created_by')) {
                $model->created_by = $userId;
            }

            if ($userId && self::checkUserStampColumn($model->getTable(), 'updated_by')) {
                $model->updated_by = $userId;
            }
        });

        static::updating(function ($model) {
            $userId = Auth::user()->employee_id;
            if ($userId && self::checkUserStampColumn($model->getTable(), 'updated_by')) {
                $model->updated_by = $userId;
            }
        });

    }

    public static function checkUserStampColumn($model, $column): bool
    {
        return Schema::hasColumn($model, $column);
    }

    public function manualUpdateTimeStamps(bool $wasModelChanged): void
    {
        if (!$wasModelChanged && $this->updated_at) {
            $this->updated_at = Carbon::now()->format('Y-m-d H:i:s');
            $this->save();
        }
    }
}
