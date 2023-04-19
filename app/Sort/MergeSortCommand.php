<?php

namespace App\Sort;

use App\Interfaces\Command;

class MergeSortCommand implements Command
{
    private Sortable $target;

    public function __construct(Sortable $target)
    {
        $this->target = $target;
    }

    public function execute(): void
    {
        $data = $this->mergeSort(
            $this->target->getData()
        );

        $this->target->setData($data);
    }

    private function mergeSort(array $data): array
    {
        $count = count($data);
        if ($count <= 1)
            return $data;

        $left  = array_slice($data, 0, (int)($count / 2));
        $right = array_slice($data, (int)($count / 2));

        $left = $this->mergeSort($left);
        $right = $this->mergeSort($right);

        return $this->merge($left, $right);
    }

    private function merge(array $left, array $right): array
    {
        $result = [];
        while (count($left) > 0 && count($right) > 0) {
            if ($left[0] < $right[0]) {
                array_push($result, array_shift($left));
            } else {
                array_push($result, array_shift($right));
            }
        }

        array_splice($result, count($result), 0, $left);
        array_splice($result, count($result), 0, $right);

        return $result;
    }
}
