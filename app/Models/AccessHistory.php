<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $access_count;
 * @property int $hour;
 * @mixin IdeHelperAccessHistory
 */
class AccessHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'system_id',
        'accessible_type',
        'accessible_id',
        'action',
        'result_classification',
        'message',
        'access_at',
    ];

    public $timestamps = false;

    public static $selectProps = [
        'snet_access_histories.id',
        'snet_access_histories.employee_id',
        'snet_access_histories.system_id',
        'snet_access_histories.accessible_type',
        'snet_access_histories.accessible_id',
        'snet_access_histories.action',
        'snet_access_histories.result_classification',
        'snet_access_histories.message',
        'snet_access_histories.access_at',
    ];

    protected $table = 'snet_access_histories';

    public static function boot(): void
    {
        parent::boot();
    }

    /**
     * Get the parent attachable model (company or employee).
     */
    public function accessible(): MorphTo
    {
        return $this->morphTo();
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function system(): BelongsTo
    {
        return $this->belongsTo(System::class);
    }
}
