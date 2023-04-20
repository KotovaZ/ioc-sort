<?php

namespace App\Sort;

use App\Interfaces\Command;
use App\Interfaces\Container;
use App\MacroCommand;

class FileSortCommand implements Command
{
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function execute(): void
    {
        $inputPath = $this->container->resolve('Sort.File.Input');
        $outputPath = $this->container->resolve('Sort.File.Output');
        $sortableObject = $this->container->resolve('Sortable');

        $readCommand = $this->container->resolve(
            'IO.File.Read',
            $inputPath,
            $sortableObject
        );
        $sortCommand = $this->container->resolve(
            $this->container->resolve('Sort.Type'),
            $sortableObject
        );
        $writeCommand = $this->container->resolve(
            'IO.File.Write',
            $outputPath,
            $sortableObject
        );

        $macroCommand = new MacroCommand($readCommand, $sortCommand, $writeCommand);
        $macroCommand->execute();
    }
}
