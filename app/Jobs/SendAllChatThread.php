<?php

namespace App\Jobs;

use App\Events\GotNewThreadChat;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendAllChatThread implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $tries = 3; // Number of retries

    /**
     * Create a new job instance.
     */
    public function __construct(public array $chatThreads)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //fire an event
        GotNewThreadChat::dispatch($this->chatThreads);
    }
}
