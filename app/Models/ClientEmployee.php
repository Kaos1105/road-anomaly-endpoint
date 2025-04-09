<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @mixin IdeHelperClientEmployee
 */
class ClientEmployee extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'client_site_id',
        'employee_id',
        'role',
        'memo',
        'display_order',
        'use_classification',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    public static $selectProps = [
        'negotiation_client_employees.id',
        'negotiation_client_employees.client_site_id',
        'negotiation_client_employees.employee_id',
        'negotiation_client_employees.role',
        'negotiation_client_employees.memo',
        'negotiation_client_employees.display_order',
        'negotiation_client_employees.use_classification',
        'negotiation_client_employees.created_by',
        'negotiation_client_employees.updated_by',
        'negotiation_client_employees.created_at',
        'negotiation_client_employees.updated_at',
    ];

    protected $table = 'negotiation_client_employees';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m',
        'updated_at' => 'datetime:Y-m-d H:m',
    ];


    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'updated_by');
    }

    public function negotiable(): MorphMany
    {
        return $this->morphMany(NegotiationEmployee::class, 'negotiable');
    }
}
