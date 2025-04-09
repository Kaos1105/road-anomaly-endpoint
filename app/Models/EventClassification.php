<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperEventClassification
 */
class EventClassification extends Model
{
    use HasFactory;

    protected $table = 'social_event_classifications';

    protected $fillable = [
        'id',
        'name',
        'description',
        'operation_rule',
        'social_criteria',
        'memo',
        'display_order',
        'use_classification',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];

    public static array $selectProps = [
        'social_event_classifications.id',
        'social_event_classifications.name',
        'social_event_classifications.description',
        'social_event_classifications.operation_rule',
        'social_event_classifications.social_criteria',
        'social_event_classifications.memo',
        'social_event_classifications.display_order',
        'social_event_classifications.use_classification',
        'social_event_classifications.created_by',
        'social_event_classifications.created_at',
        'social_event_classifications.updated_by',
        'social_event_classifications.updated_at',
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

    public function socialEvents(): HasMany
    {
        return $this->hasMany(SocialEvent::class, 'event_id', 'id');
    }
}
