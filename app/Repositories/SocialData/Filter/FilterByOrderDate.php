<?php

namespace App\Repositories\SocialData\Filter;

use App\Enums\Workflow\ExecutionOrderEnum;
use App\Enums\Workflow\WorkflowOrderEnum;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterByOrderDate implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->whereHas('workflows', function (EloquentBuilder $workflowQuery) use ($value) {
            $workflowQuery->where([
                'workflow_order' => WorkflowOrderEnum::ORDER,
                'execution_type' => ExecutionOrderEnum::ORDERED
            ]);
            if ($value) {
                $workflowQuery->whereDate('social_workflows.execution_at', $value);
            }
        });
    }
}
