<?php

namespace App\Services\Display;

use App\Enums\AccessHistory\AccessActionTypeEnum;
use App\Enums\AccessHistory\AccessibleTypeEnum;
use App\Enums\AccessHistory\AccessibleTypeSystemCodeEnum;
use App\Enums\Common\UseFlagEnum;
use App\Helpers\SystemHelper;
use App\Http\DTO\QueryParam\DisplayDropdownParam;
use App\Models\AccessHistory;
use App\Models\Display;
use App\Query\FAQ\QuestionDropdownQuery;
use App\Repositories\Display\IDisplayRepository;
use App\Trait\HasPermission;
use BenSampo\Enum\Exceptions\InvalidEnumKeyException;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Throwable;

class DisplayService implements IDisplayService
{
    use HasPermission;

    public function __construct(
        public IDisplayRepository $displayRepository,
    )
    {
    }

    public function getRepo(): IDisplayRepository
    {
        return $this->displayRepository;
    }

    public function getList(): Collection|EloquentCollection
    {
        $request = request();
        $filter = $request['filter'];
        if ($filter && $filter['system_id']) {
            return $this->displayRepository->getList();
        }
        return collect();

    }

    public function getListQuestions(): Collection|EloquentCollection
    {
        $filter = request('filter');
        if (empty($filter)) {
            return collect();
        }

        $query = new QuestionDropdownQuery(new Request());
        $displayId = $filter['id'];
        if ($displayId) {
            $display = $this->displayRepository->findDisplay($displayId);
            if ($display === null) {
                return collect();
            }
            $query->setFilterParam(new DisplayDropdownParam(systemId: $display->system_id, search: $filter['search'] ?? null));

        } else {
            return collect();
        }
        $userPermission = $this->getAllPermission($display->system_id);

        return $this->displayRepository->getListQuestions($query, $userPermission);
    }

    public function getChildNames(Display $display): ?string
    {
        $countRelation = $this->displayRepository->checkRelations($display);
        if ($countRelation->questions_count > 0) {
            return __('attributes.display.similar_FAQ');
        }
        return null;

    }

    /**
     * @throws InvalidEnumKeyException
     * @throws Throwable
     */
    public function deleteRecord(Display $display): void
    {
        DB::transaction(function () use ($display) {
            $this->logAndDelete($display->contents, AccessibleTypeEnum::CONTENT);
            $this->logAndDelete($display->announcements, AccessibleTypeEnum::ANNOUNCEMENTS);
            $display->delete();
        });
    }

    private function logAndDelete($models, string $type): void
    {
        if (count($models) === 0) return;
        $accessHistories = $models->map(function ($model) use ($type) {
            return AccessHistory::make([
                'employee_id' => \Auth::user()->employee_id,
                'system_id' => SystemHelper::getSystemId(AccessibleTypeSystemCodeEnum::fromKey($type)->value),
                'action' => AccessActionTypeEnum::DELETE,
                'accessible_type' => $type,
                'accessible_id' => $model->id,
                'message' => $type === AccessibleTypeEnum::CONTENT ? $model->no . ' ' . $model->name : $model->title . ' (' . $model->title . '〜)',
                'access_at' => Carbon::now(),
            ]);
        });
        AccessHistory::insert($accessHistories->toArray());
    }

    public function exportData(): EloquentCollection
    {
        $request = request();
        $filter = $request['filter'];
        if (!empty($filter['screen_code'])) {
            $filter = ['screen_code' => $filter['screen_code']];
        }
        $request->merge(['filter' => $filter]);
        return $this->displayRepository->getDataExport();
    }

    public function getDisplaysForDropdown(int $systemId): Collection
    {
        if (!$systemId) return collect();
        return Display::whereSystemId($systemId)->where('use_classification', UseFlagEnum::USE)->orderBy('display_order')->get();
    }
}
