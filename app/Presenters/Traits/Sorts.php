<?php declare(strict_types = 1);

namespace App\Presenters\Traits;

use App\Model\Sort\Sort;

trait Sorts {

    public function getSortColumns(): array
    {
        return [];
    }

    public function getDefaultSort(): ?Sort
    {
        return null;
    }

    public function getSort(?string $id): ?Sort
    {
        $columns = $this->getSortColumns();

        if (array_key_exists($id, $columns)) {
            return $columns[$id];
        }

        return $this->getDefaultSort();
    }

}