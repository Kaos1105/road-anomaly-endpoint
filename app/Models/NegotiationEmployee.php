<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @mixin IdeHelperNegotiationEmployee
 */
class NegotiationEmployee extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'negotiation_id',
        'negotiable_type',
        'negotiable_id',
    ];

    public static $selectProps = [
        'negotiation_negotiation_employees.id',
        'negotiation_negotiation_employees.negotiation_id',
        'negotiation_negotiation_employees.negotiable_type',
        'negotiation_negotiation_employees.negotiable_id',
    ];

    protected $table = 'negotiation_negotiation_employees';

    public $timestamps = false;

    /**
     * Get the parent attachable model (company or employee).
     */
    public function negotiable(): MorphTo
    {
        return $this->morphTo();
    }
}
