<?php

namespace App\Events;

use App\Http\Resources\ChatContent\ChatContentItemResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Log;

class GotNewThreadChat implements ShouldBroadcast, ShouldDispatchAfterCommit
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public array $chatThreads)
    {
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>auth
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('admin_threads.' . $this->chatThreads[0]['admin_employee_id']),
        ];
    }
}
