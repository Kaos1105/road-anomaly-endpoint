<?php

namespace App\Services\Content;

use App\Repositories\Content\IContentRepository;
use App\Repositories\Display\IDisplayRepository;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class ContentService implements IContentService
{
    public function __construct(
        public IContentRepository $contentRepository,
        public IDisplayRepository $displayRepository,
    )
    {
    }

    public function getRepo(): IContentRepository
    {
        return $this->contentRepository;
    }

    public function getList(): Collection|EloquentCollection
    {
        if (request('filter') && request('filter')['display_id']) {
            return $this->contentRepository->getList();
        }
        return collect();
    }


    public function exportData(): EloquentCollection
    {
        $request = request();
        $filter = $request['filter'];
        if (!empty($filter['screen_code'])) {
            $filter = ['screen_code' => $filter['screen_code']];
        }

        $request->merge(['filter' => $filter]);
        return $this->contentRepository->getDataExport();
    }
}
