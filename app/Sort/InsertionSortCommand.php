<?php

namespace App\Sort;

use App\Interfaces\Command;

class InsertionSortCommand implements Command
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

        for ($i = 1; $i < $count; $i++) {
            $cur_val = $data[$i];
            $j = $i - 1;

            while (isset($data[$j]) && $data[$j] > $cur_val) {
                $data[$j + 1] = $data[$j];
                $data[$j] = $cur_val;
                $j--;
            }
        }

        $this->target->setData($data);
    }
}
