<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperChatNotification
 */
class ChatNotification extends Model
{
    use HasFactory;

    protected $table = 'snet_chat_notifications';

    public $timestamps = false;
    
    protected $fillable = [
        'id',
        'chat_thread_id',
        'chat_content_id',
        'employee_id',
        'read_flag',
        'read_at',
    ];

    public static array $selectProps = [
        'snet_chat_notifications.id',
        'snet_chat_notifications.chat_thread_id',
        'snet_chat_notifications.chat_content_id',
        'snet_chat_notifications.employee_id',
        'snet_chat_notifications.read_flag',
        'snet_chat_notifications.read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime:Y-m-d H:m',
    ];

    public function chatContent(): BelongsTo
    {
        return $this->belongsTo(ChatContent::class, 'chat_content_id');
    }

    public function chatThread(): BelongsTo
    {
        return $this->belongsTo(ChatThread::class, 'chat_thread_id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
