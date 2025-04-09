<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperDisplay
 */
class Display extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'system_id',
        'code',
        'name',
        'display_classification',
        'memo',
        'display_order',
        'use_classification',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];

    public static $selectProps = [
        'snet_displays.id',
        'snet_displays.system_id',
        'snet_displays.code',
        'snet_displays.name',
        'snet_displays.display_classification',
        'snet_displays.memo',
        'snet_displays.display_order',
        'snet_displays.use_classification',
        'snet_displays.created_by',
        'snet_displays.created_at',
        'snet_displays.updated_by',
        'snet_displays.updated_at',
    ];

    protected $table = 'snet_displays';


    public function system(): BelongsTo
    {
        return $this->belongsTo(System::class, 'system_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'updated_by');
    }

    public function contents(): HasMany
    {
        return $this->hasMany(Content::class, 'display_id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'display_id');
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class, 'display_id');
    }

}
