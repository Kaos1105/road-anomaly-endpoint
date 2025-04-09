<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperWorkflow
 */
class Workflow extends Model
{
    use HasFactory;

    protected $table = 'social_workflows';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'social_data_id',
        'workflow_order',
        'scheduled_person_id',
        'executor_id',
        'execution_type',
        'execution_at',
    ];

    public static array $selectProps = [
        'social_workflows.id',
        'social_workflows.social_data_id',
        'social_workflows.workflow_order',
        'social_workflows.scheduled_person_id',
        'social_workflows.executor_id',
        'social_workflows.execution_type',
        'social_workflows.execution_at',
    ];

    protected $casts = [
        'execution_at' => 'datetime:Y-m-d H:m',
    ];

    public function scheduledPerson(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'scheduled_person_id');
    }

    public function executor(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'executor_id');
    }

    public function socialData(): BelongsTo
    {
        return $this->belongsTo(SocialData::class, 'social_data_id');
    }
}
