<?php

namespace App\Sort;

use App\Interfaces\UObject;

class SortableAdapter implements Sortable
{
    private UObject $targetObject;

    public function __construct(UObject $targetObject)
    {
        $this->targetObject = $targetObject;
    }

    public function getData(): array
    {
        return (array)$this->targetObject->getProperty('data');
    }

    public function setData(array $data): void
    {
        $this->targetObject->setProperty('data', $data);
    }
}
