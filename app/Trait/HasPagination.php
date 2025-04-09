<?php

namespace App\Trait;

use App\Enums\Common\PaginationEnum;

trait HasPagination
{
    public function getPerPage(): int
    {
        $perPage = (int) request()->query('perPage', PaginationEnum::PER_PAGE);

        return $perPage >= 1 && $perPage <= 100 ? $perPage : PaginationEnum::PER_PAGE;
    }

    public function getCursorPerPage(?int $defaultPerPage = PaginationEnum::CURSOR_PER_PAGE): int
    {
        $perPage = (int) request()->query('perPage', $defaultPerPage);

        return $perPage >= 1 && $perPage <= 100 ? $perPage : PaginationEnum::CURSOR_PER_PAGE;
    }

    public function getPage(): int
    {
        $page = (int) request()->query('page', PaginationEnum::FIRST_PAGE);

        return $page > 0 ? $page : PaginationEnum::FIRST_PAGE;
    }

    public function paginationRule(): array
    {
        return [
            'page' => 'integer|min:1',
            'perPage' => 'integer|min:1',
        ];
    }

    public function getLargePerPage(): int
    {
        $perPage = (int) request()->query('perPage', PaginationEnum::PER_PAGE_1000);

        return $perPage >= 1 && $perPage <= 4000 ? $perPage : PaginationEnum::PER_PAGE_1000;
    }
}
