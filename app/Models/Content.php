<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperContent
 */
class Content extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'display_id',
        'no',
        'classification',
        'name',
        'permission_1',
        'permission_2',
        'permission_3',
        'permission_4',
        'memo',
        'display_order',
        'use_classification',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];

    public static $selectProps = [
        'snet_contents.id',
        'snet_contents.display_id',
        'snet_contents.no',
        'snet_contents.classification',
        'snet_contents.name',
        'snet_contents.permission_1',
        'snet_contents.permission_2',
        'snet_contents.permission_3',
        'snet_contents.permission_4',
        'snet_contents.memo',
        'snet_contents.display_order',
        'snet_contents.use_classification',
        'snet_contents.created_by',
        'snet_contents.created_at',
        'snet_contents.updated_by',
        'snet_contents.updated_at',
    ];

    protected $table = 'snet_contents';


    public function display(): BelongsTo
    {
        return $this->belongsTo(Display::class, 'display_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'updated_by');
    }
}
