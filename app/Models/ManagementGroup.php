<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperManagementGroup
 */
class ManagementGroup extends Model
{
    use HasFactory;

    protected $table = 'social_management_groups';

    protected $fillable = [
        'id',
        'name',
        'sender_post_code',
        'sender_address_1',
        'sender_address_2',
        'sender_address_3',
        'sender_name',
        'contact_point',
        'contact_phone',
        'preparatory_personnel_id',
        'applicant_id',
        'approver_id',
        'final_decision_maker_id',
        'ordering_personnel_id',
        'payment_personnel_id',
        'completion_personnel_id',
        'memo',
        'display_order',
        'use_classification',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];

    public static array $selectProps = [
        'social_management_groups.id',
        'social_management_groups.name',
        'social_management_groups.sender_post_code',
        'social_management_groups.sender_address_1',
        'social_management_groups.sender_address_2',
        'social_management_groups.sender_address_3',
        'social_management_groups.sender_name',
        'social_management_groups.contact_point',
        'social_management_groups.contact_phone',
        'social_management_groups.preparatory_personnel_id',
        'social_management_groups.applicant_id',
        'social_management_groups.approver_id',
        'social_management_groups.final_decision_maker_id',
        'social_management_groups.ordering_personnel_id',
        'social_management_groups.payment_personnel_id',
        'social_management_groups.completion_personnel_id',
        'social_management_groups.memo',
        'social_management_groups.display_order',
        'social_management_groups.use_classification',
        'social_management_groups.created_by',
        'social_management_groups.created_at',
        'social_management_groups.updated_by',
        'social_management_groups.updated_at',
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

    public function customerCategories(): HasMany
    {
        return $this->hasMany(CustomerCategory::class, 'group_id', 'id');
    }

    public function preparatoryPersonnel(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'preparatory_personnel_id');
    }

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'applicant_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'approver_id');
    }

    public function finalDecisionMaker(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'final_decision_maker_id');
    }

    public function orderingPersonnel(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'ordering_personnel_id');
    }

    public function paymentPersonnel(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'payment_personnel_id');
    }

    public function completionPersonnel(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'completion_personnel_id');
    }

    public function socialEvents(): HasMany
    {
        return $this->hasMany(SocialEvent::class, 'group_id', 'id');
    }
}
