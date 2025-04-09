<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @mixin IdeHelperNegotiation
 */
class Negotiation extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'client_site_id',
        'date_time',
        'progress_classification',
        'purpose',
        'result',
        'manager_comment',
        'like_counter',
        'manager_comment_by',
        'manager_comment_at',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    public static $selectProps = [
        'negotiation_negotiations.id',
        'negotiation_negotiations.client_site_id',
        'negotiation_negotiations.date_time',
        'negotiation_negotiations.progress_classification',
        'negotiation_negotiations.purpose',
        'negotiation_negotiations.result',
        'negotiation_negotiations.manager_comment',
        'negotiation_negotiations.like_counter',
        'negotiation_negotiations.manager_comment_by',
        'negotiation_negotiations.manager_comment_at',
        'negotiation_negotiations.created_by',
        'negotiation_negotiations.updated_by',
        'negotiation_negotiations.created_at',
        'negotiation_negotiations.updated_at',
    ];

    protected $table = 'negotiation_negotiations';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m',
        'updated_at' => 'datetime:Y-m-d H:m',
        'management_comment_at' => 'datetime:Y-m-d H:m',
    ];

    public $timestamps = false;

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'updated_by');
    }

    public function commentBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'manager_comment_by');
    }

    public function participants(): HasMany
    {
        return $this->hasMany(NegotiationEmployee::class, 'negotiation_id');
    }

    public function clientSite(): BelongsTo
    {
        return $this->belongsTo(ClientSite::class, 'client_site_id');
    }

    public function site(): HasOneThrough
    {
        return $this->hasOneThrough(Site::class, ClientSite::class, 'id', 'id', 'client_site_id', 'site_id');
    }

    public function attachmentFiles(): MorphMany
    {
        return $this->morphMany(AttachmentFile::class, 'attachable');
    }

    public function managementDepartment(): HasOneThrough
    {
        return $this->hasOneThrough(ManagementDepartment::class, ClientSite::class, 'id', 'id', 'client_site_id', 'management_department_id');
    }
}
