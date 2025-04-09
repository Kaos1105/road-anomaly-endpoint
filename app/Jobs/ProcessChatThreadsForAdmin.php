<?php

namespace App\Jobs;

use App\Http\Resources\ChatThread\ChatThreadNotifyResource;
use App\Models\AccessPermission;
use App\Models\ChatThread;
use App\Repositories\AccessPermission\IAccessPermissionRepository;
use App\Repositories\ChatThread\IChatThreadRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class ProcessChatThreadsForAdmin implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $tries = 3; // Number of retries

    /**
     * Create a new job instance.
     */
    public function __construct(public string $systemCode)
    {

    }

    /**
     * Execute the job.
     */
    public function handle(IChatThreadRepository $chatTheadRepository, IAccessPermissionRepository $accessPermissionRepository): void
    {
        $accessPermissions = $accessPermissionRepository->getSystemAccessiblePermission($this->systemCode);
        $adminEmployeeIds = $accessPermissions->map(fn(AccessPermission $permission) => $permission->employee_id)->unique()->values();
        $chatThreads = $chatTheadRepository->getNotificationChatThreads();

        $adminEmployeeIds->each(function (int $employeeId) use ($chatThreads) {
            $resourceCollection = $this->mapNotificationData($chatThreads, $employeeId);

            if ($resourceCollection->count() > 0) {
                SendAllChatThread::dispatch($resourceCollection->toArray());
            }
        });
    }

    protected function mapNotificationData(Collection $chatThreads, int $employeeId): Collection
    {
        return $chatThreads->map(function (ChatThread $chatThread) use ($employeeId) {
            return (new ChatThreadNotifyResource($chatThread))->setParams($employeeId)->toArray(request());
        })->sortByDesc(function (array $chatThread, int $key) {
            return $chatThread['last_chat_at'];
        })->values();
    }
}
