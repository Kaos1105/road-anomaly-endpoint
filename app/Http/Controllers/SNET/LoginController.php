<?php

namespace App\Http\Controllers\SNET;

use App\Enums\Common\UseFlagEnum;
use App\Enums\ScreenName\ScreenCodeEnum;
use App\Http\Controllers\Controller;
use App\Http\DTO\Login\LoginScreenData;
use App\Http\DTO\ResponseData;
use App\Services\Announcement\IAnnouncementService;
use App\Services\Content\IContentService;
use App\Services\Display\IDisplayService;

class LoginController extends Controller
{
    public function __construct(
        private readonly IContentService      $contentService,
        private readonly IAnnouncementService $announcementService,
        private readonly IDisplayService      $displayService,
    )
    {
    }

    public function getContent(): ResponseData
    {
        $displayLogin = $this->displayService->getRepo()->findDisplayByCode(ScreenCodeEnum::LOGIN, UseFlagEnum::USE);
        if (!$displayLogin) {
            return $this->httpOk(new LoginScreenData());
        }

        $contents = $this->contentService->getRepo()->getListByDisplay($displayLogin->id);
        $announcements = $this->announcementService->getPostingLogin($displayLogin);

        return $this->httpOk(new LoginScreenData($contents, $announcements));
    }
}
