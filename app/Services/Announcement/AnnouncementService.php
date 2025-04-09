<?php

namespace App\Services\Announcement;

use App\Enums\ScreenName\ScreenCodeEnum;
use App\Http\DTO\Announcement\AnnouncementPostingContentData;
use App\Models\AccessHistory;
use App\Models\Announcement;
use App\Models\Display;
use App\Models\PersonalAccessToken;
use App\Repositories\AccessHistory\IAccessHistoryRepository;
use App\Repositories\Announcement\IAnnouncementRepository;
use App\Repositories\Display\IDisplayRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;


class AnnouncementService implements IAnnouncementService
{
    public function __construct(
        public IAnnouncementRepository  $announcementRepository,
        public IDisplayRepository       $displayRepository,
        public IAccessHistoryRepository $accessHistoryRepository
    )
    {
    }

    public function getRepo(): IAnnouncementRepository
    {
        return $this->announcementRepository;
    }

    public function getPostingByDisplayCode(): AnnouncementPostingContentData
    {
        $filter = request('filter');
        if (!$filter || empty($filter['code'])) {
            return new AnnouncementPostingContentData();
        }

        $display = $this->displayRepository->findDisplayByCode($filter['code']);
        if (!$display) {
            return new AnnouncementPostingContentData();
        }

        $announcements = $this->announcementRepository->findPostingByDisplay($display);
        if ($display->code == ScreenCodeEnum::MAIN_DASHBOARD) {

            $loginAccessHistories = $this->accessHistoryRepository->getTwoLastLoginHistory();
            $currentLoginHistory = $loginAccessHistories->first();
            /**
             * @var AccessHistory $currentLoginHistory
             */
            if ($loginAccessHistories->count() > 1) {
                $previousLoginHistory = $loginAccessHistories->last();
                /**
                 * @var AccessHistory $previousLoginHistory
                 */
                $newPosting = $announcements->filter(function (Announcement $announcement) use ($previousLoginHistory, $currentLoginHistory) {
                    return $announcement->created_at >= $previousLoginHistory->access_at && $announcement->created_at <= $currentLoginHistory->access_at;
                });
                $isNew = $newPosting->count() > 0;
            } else {
                $isNew = $announcements->count() > 0;
            }
            if ($isNew) {
                $accessPortalCount = $this->accessHistoryRepository->countAccessPortalDuringLogin($display->system_id);
                //NOTE: User have access portal screen the first time
                $isNew = $accessPortalCount < 2;
            }
            return new AnnouncementPostingContentData($isNew, $announcements);
        } else {
            return new AnnouncementPostingContentData(false, $announcements);
        }
    }

    public function getPostingLogin(Display $display): Collection
    {
        return $this->announcementRepository->findPostingByDisplay($display);
    }

}
