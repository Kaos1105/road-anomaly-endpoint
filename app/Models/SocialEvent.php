<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperSocialEvent
 */
class SocialEvent extends Model
{
    use HasFactory;

    protected $table = 'social_social_events';

    protected $fillable = [
        'id',
        'group_id',
        'event_id',
        'event_title',
        'event_progress',
        'planned_start',
        'creation_deadline',
        'approval_deadline',
        'order_deadline',
        'planned_completion',
        'plan_comment',
        'actual_comment',
        'memo',
        'use_classification',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    public static array $selectProps = [
        'social_social_events.id',
        'social_social_events.group_id',
        'social_social_events.event_id',
        'social_social_events.event_title',
        'social_social_events.event_progress',
        'social_social_events.planned_start',
        'social_social_events.creation_deadline',
        'social_social_events.approval_deadline',
        'social_social_events.order_deadline',
        'social_social_events.planned_completion',
        'social_social_events.plan_comment',
        'social_social_events.actual_comment',
        'social_social_events.memo',
        'social_social_events.use_classification',
        'social_social_events.created_by',
        'social_social_events.updated_by',
        'social_social_events.created_at',
        'social_social_events.updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m',
        'updated_at' => 'datetime:Y-m-d H:m',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'updated_by');
    }

    public function eventClassification(): BelongsTo
    {
        return $this->belongsTo(EventClassification::class, 'event_id');
    }

    public function managementGroup(): BelongsTo
    {
        return $this->belongsTo(ManagementGroup::class, 'group_id');
    }

    public function socialData(): HasMany
    {
        return $this->hasMany(SocialData::class, 'social_event_id', 'id');
    }
}
