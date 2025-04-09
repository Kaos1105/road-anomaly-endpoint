<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperAuthenticationHistory
 */
class AuthenticationHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'action',
        'message',
        'authen_at',
    ];

    public $timestamps = false;

    public static $selectProps = [
        'snet_authen_histories.id',
        'snet_authen_histories.employee_id',
        'snet_authen_histories.action',
        'snet_authen_histories.message',
        'snet_authen_histories.authen_at',
    ];

    protected $table = 'snet_authen_histories';

    public static function boot(): void
    {
        parent::boot();
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

}
