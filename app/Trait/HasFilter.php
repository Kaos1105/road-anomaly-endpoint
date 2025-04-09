<?php

namespace App\Trait;

use Spatie\QueryBuilder\AllowedFilter;

trait HasFilter
{
    public function setParamValue(AllowedFilter $filter, array $paramArr): void
    {
        $paramValue = array_key_exists($filter->getName(), $paramArr) ? $paramArr[$filter->getName()] : null;
        if ($paramValue != null) {
            $filter->filter($this, $paramValue);
        }
    }

    public function setUseClassification(?int $useClassification): static
    {
        if ($useClassification) {
            $this->where('use_classification', $useClassification)->orderBy('id');
        }

        return $this;
    }
}
