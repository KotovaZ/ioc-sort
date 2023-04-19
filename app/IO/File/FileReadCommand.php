<?php

namespace App\IO\File;

use App\Exceptions\NotFoundException;
use App\Interfaces\Command;
use App\Sort\Sortable;

class FileReadCommand implements Command
{
    private Sortable $target;
    private string $path;

    public function __construct(string $path, Sortable $target)
    {
        $this->path = $path;
        $this->target = $target;
    }

    public function execute(): void
    {
        if (!file_exists($this->path)) {
            $message = sprintf('Файл по пути %s не найден', $this->path);
            throw new NotFoundException($message);
        }

        $fileData = file_get_contents($this->path);
        $data = explode(PHP_EOL, $fileData);

        $this->target->setData($data);
    }
}
