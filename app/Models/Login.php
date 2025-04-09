<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

/**
 * @mixin IdeHelperLogin
 */
class Login extends Authenticatable
{
    use HasFactory, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'employee_id',
        'login_id',
        'password',
        'password_decrypt',
        'password_updated_at',
        'authen_at',
        'authen_flag',
        'previous_login_at',
        'memo',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
    ];

    public static $selectProps = [
        'snet_logins.id',
        'snet_logins.employee_id',
        'snet_logins.login_id',
        'snet_logins.password',
        'snet_logins.password_decrypt',
        'snet_logins.password_updated_at',
        'snet_logins.authen_at',
        'snet_logins.authen_flag',
        'snet_logins.previous_login_at',
        'snet_logins.memo',
        'snet_logins.created_at',
        'snet_logins.created_by',
        'snet_logins.updated_at',
        'snet_logins.updated_by',
    ];

    protected $table = 'snet_logins';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    protected function password(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => $value,
            set: fn(string $value) => Hash::make($value),
        );
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function personalAccessTokens(): MorphMany
    {
        return $this->morphMany(PersonalAccessToken::class, 'tokenable');
    }
}
