<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favorite> $employeeFavorites
 * @property-read int|null $employee_favorites_count
 * @property-read int|null $customer_count
 * @property-read int|null $customerResponsive_count
 * @property-read int|null $managementGroupPreparatoryPersonnel_count
 * @property-read int|null $managementGroupApplicant_count
 * @property-read int|null $managementGroupApprover_count
 * @property-read int|null $managementGroupFinalDecisionMaker_count
 * @property-read int|null $managementGroupOrderingPersonnel_count
 * @property-read int|null $managementGroupPaymentPersonnel_count
 * @property-read int|null $managementGroupCompletionPersonnel_count
 * @property-read int|null $supplierPerson_count
 * @property-read int|null $supplierCompanyPerson_count
 * @mixin IdeHelperEmployee
 */
class Employee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'code',
        'last_name',
        'first_name',
        'kana',
        'day_of_birth',
        'day_of_death',
        'period_accuracy_flg',
        'employees_classification',
        'maiden_name',
        'previous_name_flg',
        'gender',
        'en_notation',
        'company_email',
        'company_phone',
        'post_code',
        'address_1',
        'address_2',
        'address_3',
        'phone',
        'email',
        'memo',
        'display_order',
        'use_classification',
        'update_history',
        'biography',
        'created_by',
        'updated_by',
    ];

    public static $selectProps = [
        'organization_employees.id',
        'organization_employees.code',
        'organization_employees.last_name',
        'organization_employees.first_name',
        'organization_employees.kana',
        'organization_employees.day_of_birth',
        'organization_employees.day_of_death',
        'organization_employees.period_accuracy_flg',
        'organization_employees.employees_classification',
        'organization_employees.maiden_name',
        'organization_employees.previous_name_flg',
        'organization_employees.gender',
        'organization_employees.en_notation',
        'organization_employees.company_email',
        'organization_employees.company_phone',
        'organization_employees.post_code',
        'organization_employees.address_1',
        'organization_employees.address_2',
        'organization_employees.address_3',
        'organization_employees.phone',
        'organization_employees.email',
        'organization_employees.memo',
        'organization_employees.display_order',
        'organization_employees.use_classification',
        'organization_employees.update_history',
        'organization_employees.biography',
        'organization_employees.created_by',
        'organization_employees.created_at',
        'organization_employees.updated_by',
        'organization_employees.updated_at',
    ];

    protected $table = 'organization_employees';

    public function accessPermissions(): HasMany
    {
        return $this->hasMany(AccessPermission::class, 'employee_id', 'id');
    }

    public function systems(): HasManyThrough
    {
        return $this->hasManyThrough(System::class, AccessPermission::class);
    }

    public function accessHistories(): HasMany
    {
        return $this->hasMany(AccessHistory::class, 'employee_id', 'id');
    }

    public function logins(): HasMany
    {
        return $this->hasMany(Login::class, 'employee_id', 'id');
    }

    public function transfers(): HasMany
    {
        return $this->hasMany(Transfer::class, 'employee_id', 'id');
    }

    public function attachmentFiles(): MorphMany
    {
        return $this->morphMany(AttachmentFile::class, 'attachable');
    }

    public function favorites(): MorphMany
    {
        return $this->morphMany(Favorite::class, 'favorable');
    }

    public function employeeFavorites(): MorphMany
    {
        return $this->favorites()
            ->where('employee_id', \Auth::user()->employee_id);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'updated_by');
    }

    // 300000

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'employee_id', 'id');
    }

    public function customerResponsive(): HasMany
    {
        return $this->hasMany(Customer::class, 'responsible_id', 'id');
    }

    public function managementGroupPreparatoryPersonnel(): HasMany
    {
        return $this->hasMany(ManagementGroup::class, 'preparatory_personnel_id');
    }

    public function managementGroupApplicant(): HasMany
    {
        return $this->hasMany(ManagementGroup::class, 'applicant_id', 'id');
    }

    public function managementGroupApprover(): HasMany
    {
        return $this->hasMany(ManagementGroup::class, 'approver_id', 'id');
    }

    public function managementGroupFinalDecisionMaker(): HasMany
    {
        return $this->hasMany(ManagementGroup::class, 'final_decision_maker_id', 'id');
    }

    public function managementGroupOrderingPersonnel(): HasMany
    {
        return $this->hasMany(ManagementGroup::class, 'ordering_personnel_id', 'id');
    }

    public function managementGroupPaymentPersonnel(): HasMany
    {
        return $this->hasMany(ManagementGroup::class, 'payment_personnel_id', 'id');
    }

    public function managementGroupCompletionPersonnel(): HasMany
    {
        return $this->hasMany(ManagementGroup::class, 'completion_personnel_id', 'id');
    }

    public function supplierPerson(): HasMany
    {
        return $this->hasMany(Supplier::class, 'supplier_person_id');
    }

    public function supplierCompanyPerson(): HasMany
    {
        return $this->hasMany(Supplier::class, 'my_company_person_id');
    }

    public function managementDepartmentEmployees(): HasManyThrough
    {
        return $this->hasManyThrough(ManagementDepartmentEmployee::class, MyCompanyEmployee::class);
    }

    public function clientEmployees(): HasMany
    {
        return $this->hasMany(ClientEmployee::class, 'employee_id', 'id');
    }

    public function chatThreads(): HasMany
    {
        return $this->hasMany(ChatThread::class, 'creator_id');
    }

    public function counterpartyContractor(): HasMany
    {
        return $this->hasMany(BasicContract::class, 'counterparty_contractor_id', 'id');
    }

    public function counterpartyRepresentative(): HasMany
    {
        return $this->hasMany(BasicContract::class, 'counterparty_representative_id', 'id');
    }

    public function contractor(): HasMany
    {
        return $this->hasMany(BasicContract::class, 'contractor_id', 'id');
    }

    public function representative(): HasMany
    {
        return $this->hasMany(BasicContract::class, 'representative_id', 'id');
    }
}
