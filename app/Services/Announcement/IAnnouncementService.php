<?php

namespace App\Services\Announcement;

use App\Http\DTO\Announcement\AnnouncementPostingContentData;
use App\Models\Display;
use App\Repositories\Announcement\IAnnouncementRepository;
use Illuminate\Support\Collection;


interface IAnnouncementService
{
    public function getRepo(): IAnnouncementRepository;

    public function getPostingByDisplayCode(): AnnouncementPostingContentData;

    public function getPostingLogin(Display $display): Collection;

}
