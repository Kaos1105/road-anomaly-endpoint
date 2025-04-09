<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperAnnouncement
 */
class Announcement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'system_id',
        'display_id',
        'announcement_classification',
        'title',
        'content',
        'start_time',
        'end_time',
        'use_classification',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];

    public static $selectProps = [
        'snet_announcements.id',
        'snet_announcements.system_id',
        'snet_announcements.display_id',
        'snet_announcements.announcement_classification',
        'snet_announcements.title',
        'snet_announcements.content',
        'snet_announcements.start_time',
        'snet_announcements.end_time',
        'snet_announcements.use_classification',
        'snet_announcements.created_by',
        'snet_announcements.created_at',
        'snet_announcements.updated_by',
        'snet_announcements.updated_at',
    ];

    protected $table = 'snet_announcements';


    public function system(): BelongsTo
    {
        return $this->belongsTo(System::class, 'system_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'updated_by');
    }

    public function display(): BelongsTo
    {
        return $this->belongsTo(Display::class, 'display_id');
    }

}
