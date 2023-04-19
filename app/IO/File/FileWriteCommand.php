<?php

namespace App\IO\File;

use App\Exceptions\Exception;
use App\Exceptions\NotFoundException;
use App\Interfaces\Command;
use App\Sort\Sortable;

class FileWriteCommand implements Command
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

        $data = implode(PHP_EOL, $this->target->getData());
        $isSuccess = file_put_contents($this->path, $data);

        if (!$isSuccess) {
            throw new Exception('Не удалось записать файл');
        }
    }
}
