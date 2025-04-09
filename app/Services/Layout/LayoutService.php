<?php

namespace App\Services\Layout;

use App\Enums\Common\DateTimeEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\Layout\LayoutBlockEnum;
use App\Http\DTO\Layout\LayoutCreateData;
use App\Http\DTO\Layout\LayoutDragDropData;
use App\Models\Content;
use App\Models\Display;
use App\Models\Layout;
use App\Repositories\Content\IContentRepository;
use App\Repositories\Display\IDisplayRepository;
use App\Repositories\Layout\ILayoutRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;

readonly class LayoutService implements ILayoutService
{

    public function __construct(
        private ILayoutRepository  $layoutRepository,
        private IContentRepository $contentRepository,
        private IDisplayRepository $displayRepository,
    )
    {
    }

    public function getRepo(): ILayoutRepository
    {
        return $this->layoutRepository;
    }

    public function getLayoutDashboard(): Collection
    {
        $filter = request('filter');
        if (!$filter || empty($filter['screen_code'])) {
            return collect();
        }

        $display = $this->displayRepository->findDisplayByCode($filter['screen_code'], UseFlagEnum::USE);
        if (!$display) {
            return collect();
        }

        $contents = $this->contentRepository->getListCardByDisplay($display->id);
        if ($contents->count() == 0) {
            return collect();
        }

        $employeeId = \Auth::user()->employee_id;

        $contentsNo = $contents->pluck('no')->toArray();
        $employeeLayout = $this->layoutRepository->findLayoutByEmployee($display->system_id, $employeeId);
        $now = Carbon::now()->format(DateTimeEnum::DATE_TIME_FORMAT_V2);

        if ($employeeLayout->count() > 0) {
            $layoutContentsNo = $employeeLayout->pluck('content_no')->toArray();
            if ($contentsNo !== $layoutContentsNo) {
                $currentContents = array_intersect($contentsNo, $layoutContentsNo);
                // Delete -> Update -> Create
                $employeeLayout = $this->deleteLayout($employeeLayout, array_diff($layoutContentsNo, $currentContents), $display, $employeeId, $now);
                $employeeLayout = $this->updateLayout($employeeLayout, array_diff($contentsNo, $layoutContentsNo), $display, $employeeId, $now);
            }
            return $employeeLayout;
        } else {
            return $this->createNewLayout($contents, $display, $employeeId, $now);
        }
    }

    private function createNewLayout(Collection $contentCollection, Display $display, int $employeeId, string $now): Collection
    {
        $dataInsert = collect();
        $blocks = LayoutBlockEnum::getValues();

        $contentCollection->each(function (Content $content, $index) use (&$dataInsert, $blocks, $display, $employeeId, $now) {
            $blockOrder = (int)(($index) / count($blocks)) + 1;
            $block = $index % count($blocks);
            $dataInsert->push(new LayoutCreateData($employeeId, $display->system_id, $blocks[$block], $blockOrder, $content->no, $now, $now));
        });

        $createLayout = $this->layoutRepository->createLayoutEmployee($dataInsert->toArray());
        if (!$createLayout) {
            return collect();
        }

        return $this->layoutRepository->findLayoutByEmployee($display->system_id, $employeeId);
    }

    private function deleteLayout(Collection $employeeLayout, array $deleteContent, Display $display, int $employeeId, string $now): Collection
    {
        $deleted = $this->layoutRepository->deleteLayoutEmployee($display->system_id, $employeeId, $deleteContent);
        if ($deleted > 0) {
            $update = $employeeLayout->filter(function (Layout $layoutContent) use ($deleteContent) {
                return !in_array($layoutContent->content_no, $deleteContent);
            });
            $updateData = collect();
            $update->groupBy('block')->each(function (Collection $blockCollection) use (&$updateData, $employeeId, $now) {
                $blockCollection->each(function (Layout $layout, $index) use (&$updateData, $employeeId, $now) {
                    if ($layout->block_order != $index + 1) {
                        $updateData->push([
                            ...$layout->toArray(),
                            'block_order' => $index + 1,
                            'updated_at' => $now,
                        ]);
                    }
                });
            });
            $this->layoutRepository->updateLayoutEmployee($updateData->toArray());
            return $this->layoutRepository->findLayoutByEmployee($display->system_id, $employeeId);
        }
        return $employeeLayout;
    }

    private function updateLayout(Collection $employeeLayout, array $createLayout, Display $display, int $employeeId, string $now): Collection
    {
        if ($createLayout) {
            $dataInsert = collect();
            $oldLayout = $employeeLayout;
            $blocks = LayoutBlockEnum::getValues();

            $employeeLayout->each(function (Layout $layout, $index) use (&$createLayout, &$dataInsert, $oldLayout, $employeeId, $display, $blocks, $now) {
                if ($index == 0 && ($layout->block != LayoutBlockEnum::BLOCK_A || $layout->block_order != 1)) {
                    for ($blockIndex = 1; $blockIndex <= $layout?->block_order ?: (count($createLayout) % 3); $blockIndex++) {
                        foreach ($blocks as $block) {
                            if ($layout->block_order == $blockIndex && $layout->block == $block) return;
                            if (empty($createLayout)) return;
                            $dataInsert->push(new LayoutCreateData($employeeId, $display->system_id, $block, $blockIndex, array_shift($createLayout), $now));
                        }
                    }
                }
                $nextLayout = $oldLayout->get($index + 1);
                $this->processLayout($layout, $nextLayout, $createLayout, $dataInsert, $display, $employeeId, $blocks, $now);
            });

            $this->layoutRepository->createLayoutEmployee($dataInsert->toArray());
            return $this->layoutRepository->findLayoutByEmployee($display->system_id, $employeeId);
        }

        return $employeeLayout;
    }

    private function processLayout(Layout $layout, ?Layout $nextLayout, array &$createLayout, Collection &$dataInsert, Display $display, int $employeeId, array $blocks, string $now): void
    {
        $addDataInsert = function (string $block, int $blockOrder) use (&$createLayout, &$dataInsert, $employeeId, $display, $now) {
            if (empty($createLayout)) return;
            $dataInsert->push(new LayoutCreateData($employeeId, $display->system_id, $block, $blockOrder, array_shift($createLayout), $now));
        };

        switch ($layout->block) {
            case LayoutBlockEnum::BLOCK_A:
                $this->handleBlockA($layout, $nextLayout, $addDataInsert, $blocks, $createLayout);
                break;

            case LayoutBlockEnum::BLOCK_B:
                $this->handleBlockB($layout, $nextLayout, $addDataInsert, $blocks, $createLayout);
                break;

            default:
                $this->handleBlockC($layout, $nextLayout, $addDataInsert, $blocks, $createLayout);
                break;
        }
    }

    private function handleBlockA(Layout $layout, ?Layout $nextLayout, callable $addDataInsert, array $blocks, array &$createLayout): void
    {
        if (!$nextLayout || $nextLayout->block_order != $layout->block_order || $nextLayout->block != LayoutBlockEnum::BLOCK_B) {
            $this->insertBlocks($layout, $nextLayout, $addDataInsert, $blocks, $createLayout, [LayoutBlockEnum::BLOCK_B, LayoutBlockEnum::BLOCK_C]);
        }
    }

    private function handleBlockB(Layout $layout, ?Layout $nextLayout, callable $addDataInsert, array $blocks, array &$createLayout): void
    {
        if (!$nextLayout || $nextLayout->block_order != $layout->block_order || $nextLayout->block != LayoutBlockEnum::BLOCK_C) {
            $addDataInsert(LayoutBlockEnum::BLOCK_C, $layout->block_order);
            if (empty($createLayout)) return;
            $this->insertBlocks($layout, $nextLayout, $addDataInsert, $blocks, $createLayout);
        }
    }

    private function handleBlockC(Layout $layout, ?Layout $nextLayout, callable $addDataInsert, array $blocks, array &$createLayout): void
    {
        if (!$nextLayout || $nextLayout->block_order != $layout->block_order + 1 || $nextLayout->block != LayoutBlockEnum::BLOCK_A) {
            $this->insertBlocks($layout, $nextLayout, $addDataInsert, $blocks, $createLayout);
        }
    }

    private function insertBlocks(Layout $layout, ?Layout $nextLayout, callable $addDataInsert, array $blocks, array &$createLayout, array $additionalBlocks = []): void
    {
        foreach ($additionalBlocks as $block) {
            if ($nextLayout && $nextLayout->block_order == $layout->block_order && $nextLayout->block == $block) return;
            if (empty($createLayout)) return;
            $addDataInsert($block, $layout->block_order);
        }

        if (empty($createLayout)) return;

        for ($blockIndex = $layout->block_order + 1; $blockIndex <= $nextLayout?->block_order ?: (count($createLayout) % 3); $blockIndex++) {
            foreach ($blocks as $block) {
                if ($nextLayout && $nextLayout->block_order == $blockIndex && $nextLayout->block == $block) return;
                $addDataInsert($block, $blockIndex);
            }
        }
    }

    public function dragDropLayoutDashboard(array $dataDragDrop): Collection
    {
        $employeeId = \Auth::user()->employee_id;

        $updateData = array_reduce($dataDragDrop, function ($block, $items) use ($employeeId) {
            if (!empty($items)) {
                foreach ($items as $item) {
                    $item['employee_id'] = $employeeId;
                    $block[] = $item;
                }
            }
            return $block;
        }, []);

        if (!empty($updateData)) {
            $blockItem = $updateData[0];
            $this->layoutRepository->updateLayoutEmployee($updateData);

            return $this->layoutRepository->findLayoutByEmployee($blockItem['system_id'], $employeeId);
        }
        return collect();
    }

    /*
    public function dragDropLayoutDashboard(array $dataDragDrop): Collection
    {
        $employeeId = \Auth::user()->employee_id;
        $start = LayoutDragDropData::from([...$dataDragDrop['start'], 'employee_id' => $employeeId]);
        $end = LayoutDragDropData::from([...$dataDragDrop['end'], 'employee_id' => $employeeId]);
        $updateData = collect();
        if ($start->block == $end->block) {
            // same block
            if ($start->blockOrder < $end->blockOrder) {
                // down
                $updateLayout = $this->layoutRepository->findLayoutBlock($start->systemId, $employeeId, $start->block, $start->blockOrder, $end->blockOrder);
                $updateLayout->each(function (Layout $layout) use (&$updateData, $start, $end) {
                    if ($layout->block_order == $start->blockOrder) {
                        $updateData->push([...$layout->toArray(), 'block_order' => $end->blockOrder]);
                    } else {
                        $updateData->push([...$layout->toArray(), 'block_order' => $layout->block_order - 1]);
                    }
                });

            } else {
                // up
                $updateLayout = $this->layoutRepository->findLayoutBlock($start->systemId, $employeeId, $start->block, $end->blockOrder, $start->blockOrder);
                $updateLayout->each(function (Layout $layout) use (&$updateData, $start, $end) {
                    if ($layout->block_order == $start->blockOrder) {
                        $updateData->push([...$layout->toArray(), 'block_order' => $end->blockOrder]);
                    } else {
                        $updateData->push([...$layout->toArray(), 'block_order' => $layout->block_order + 1]);
                    }
                });
            }
        } else {
            // diff block
            if (is_null($end->blockOrder)) {
                $blockEnd = $this->layoutRepository->findLayoutBlock($end->systemId, $employeeId, $end->block, 1);
                if ($blockEnd->count() > 0) {
                    $lastBlock = $blockEnd->last();
                    $end = LayoutDragDropData::from([...$lastBlock->toArray(), 'block_order' => $lastBlock->block_order + 1]);
                }
            }
            $blockStartLayouts = $this->layoutRepository->findLayoutBlock($start->systemId, $employeeId, $start->block, $start->blockOrder);
            $blockStartLayouts->each(function (Layout $layout) use ($start, $end, &$updateData) {
                if ($layout->block_order == $start->blockOrder) {
                    if ($end->blockOrder) {
                        $updateData->push([...$layout->toArray(), 'block' => $end->block, 'block_order' => $end->blockOrder]);
                    } else {
                        $updateData->push([...$layout->toArray(), 'block' => $end->block, 'block_order' => 1]);
                    }
                } else {
                    $updateData->push([...$layout->toArray(), 'block_order' => $layout->block_order - 1]);
                }
            });
            if ($end->blockOrder) {
                $blockEndLayouts = $this->layoutRepository->findLayoutBlock($end->systemId, $employeeId, $end->block, $end->blockOrder);
                $blockEndLayouts->each(function (Layout $layout) use ($end, &$updateData) {
                    $updateData->push([...$layout->toArray(), 'block_order' => $layout->block_order + 1]);
                });
            }
        }
        $this->layoutRepository->updateLayoutEmployee($updateData->toArray());
        return $this->layoutRepository->findLayoutByEmployee($start->systemId, $employeeId);
    }
     */
}
