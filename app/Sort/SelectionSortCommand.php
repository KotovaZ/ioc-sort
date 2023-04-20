<?php

namespace App\Sort;

use App\Interfaces\Command;

class SelectionSortCommand implements Command
{
    private Sortable $target;

    public function __construct(Sortable $target)
    {
        $this->target = $target;
    }

    public function execute(): void
    {
        $data = $this->target->getData();
        $count = count($data);

        if ($count <= 1)
            return;

        for ($i = 0; $i < $count - 1; $i++) {
            $min = $i;

            for ($j = $i + 1; $j < $count; $j++) {
                if ($data[$j] < $data[$min]) {
                    $min = $j;
                }
            }

            $temp = $data[$i];
            $data[$i] = $data[$min];
            $data[$min] = $temp;
        }

        $this->target->setData($data);
    }
}
