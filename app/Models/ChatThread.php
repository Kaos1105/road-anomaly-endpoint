<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperChatThread
 */
class ChatThread extends Model
{
    use HasFactory;

    protected $table = 'snet_chat_threads';
    
    public $timestamps = false;

    protected $fillable = [
        'id',
        'creator_id',
    ];

    public static array $selectProps = [
        'snet_chat_threads.id',
        'snet_chat_threads.creator_id',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'creator_id');
    }

    public function chatContents(): HasMany
    {
        return $this->hasMany(ChatContent::class, 'chat_thread_id');
    }

    public function chatNotifications(): HasMany
    {
        return $this->hasMany(ChatNotification::class, 'chat_thread_id');
    }
}
