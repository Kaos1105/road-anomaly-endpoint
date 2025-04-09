<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperLayout
 */
class Layout extends Model
{
    use HasFactory;

    protected $table = 'common_layouts';

    protected $fillable = [
        'id',
        'employee_id',
        'system_id',
        'content_no',
        'block',
        'block_order',
        'created_at',
        'updated_at',
    ];

    public static array $selectProps = [
        'common_layouts.id',
        'common_layouts.employee_id',
        'common_layouts.system_id',
        'common_layouts.content_no',
        'common_layouts.block',
        'common_layouts.block_order',
        'common_layouts.created_at',
        'common_layouts.updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m',
        'updated_at' => 'datetime:Y-m-d H:m',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function system(): BelongsTo
    {
        return $this->belongsTo(System::class, 'system_id');
    }
}
