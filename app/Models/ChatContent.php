<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @mixin IdeHelperChatContent
 */
class ChatContent extends Model
{
    use HasFactory;

    protected $table = 'snet_chat_contents';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'chat_thread_id',
        'employee_id',
        'chat_classification',
        'chat_text',
        'chat_at',
    ];

    public static array $selectProps = [
        'snet_chat_contents.id',
        'snet_chat_contents.chat_thread_id',
        'snet_chat_contents.employee_id',
        'snet_chat_contents.chat_classification',
        'snet_chat_contents.chat_text',
        'snet_chat_contents.chat_at',
    ];

    protected $casts = [
        'chat_at' => 'datetime:Y-m-d H:m:s',
    ];

    public function chatThread(): BelongsTo
    {
        return $this->belongsTo(ChatThread::class, 'chat_thread_id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function chatNotifications(): HasMany
    {
        return $this->hasMany(ChatNotification::class, 'chat_content_id');
    }

    public function attachmentFiles(): MorphMany
    {
        return $this->morphMany(AttachmentFile::class, 'attachable');
    }
}
