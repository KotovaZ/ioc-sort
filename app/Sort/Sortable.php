<?php

namespace App\Sort;

interface Sortable
{
    public function getData(): array;
    public function setData(array $data): void;
}
