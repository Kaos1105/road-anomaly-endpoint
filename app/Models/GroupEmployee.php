<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperGroupEmployee
 */
class GroupEmployee extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'employee_id',
        'group_id',
    ];

    public static $selectProps = [
        'main_group_members.id',
        'main_group_members.employee_id',
        'main_group_members.group_id',
    ];

    protected $table = 'main_group_members';

    public $timestamps = false;

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
}
