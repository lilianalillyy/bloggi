<?php declare(strict_types = 1);

namespace App\Model\Sort;

class Sort {

    public function __construct(
        public string $columnName,
        public string $direction
    ) {
    }

    public function toArray(): array
    {
        return [$this->columnName, $this->direction];
    }

}