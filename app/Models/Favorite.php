<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @mixin IdeHelperFavorite
 */
class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'employee_id',
        'favorable_type',
        'favorable_id',
        'updated_at',
        'updated_by',
    ];

    public static $selectProps = [
        'common_favorites.id',
        'common_favorites.employee_id',
        'common_favorites.favorable_type',
        'common_favorites.favorable_id',
        'common_favorites.updated_at',
        'common_favorites.updated_by',
    ];

    protected $table = 'common_favorites';

    public $timestamps = false;

    public static function boot(): void
    {
        parent::boot();
        static::updating(function ($model) {
            $model->updated_at = $model->freshTimestamp();
            $model->updated_by = Auth::user()->employee_id;
        });
    }

    public function favorable(): MorphTo
    {
        return $this->morphTo();
    }
}
