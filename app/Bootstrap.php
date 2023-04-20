<?php

use App\IO\File\FileReadCommand;
use App\IO\File\FileWriteCommand;
use App\IoC\IoC;
use App\MapObject;
use App\Sort\FileSortCommand;
use App\Sort\InsertionSortCommand;
use App\Sort\MergeSortCommand;
use App\Sort\SelectionSortCommand;
use App\Sort\SortableAdapter;

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
$container = new IoC;

$container->resolve(
    'IoC.Register',
    'Sortable',
    fn (...$attrs) => new SortableAdapter(new MapObject)
)->execute();

$container->resolve(
    'IoC.Register',
    'Command.Sort.Insertion',
    fn (...$attrs) => new InsertionSortCommand($attrs[0])
)->execute();

$container->resolve(
    'IoC.Register',
    'Command.Sort.Merge',
    fn (...$attrs) => new MergeSortCommand($attrs[0])
)->execute();

$container->resolve(
    'IoC.Register',
    'Command.Sort.Selection',
    fn (...$attrs) => new SelectionSortCommand($attrs[0])
)->execute();

$container->resolve(
    'IoC.Register',
    'IO.File.Read',
    fn (...$attrs) => new FileReadCommand($attrs[0], $attrs[1])
)->execute();

$container->resolve(
    'IoC.Register',
    'IO.File.Write',
    fn (...$attrs) => new FileWriteCommand($attrs[0], $attrs[1])
)->execute();

$container->resolve(
    'IoC.Register',
    'SortFile',
    function (string $inputPath, string $outputPath, string $sortCommand) use ($container) {
        $container->resolve('IoC.Register', 'Sort.File.Input', fn (...$atrs) => $inputPath)->execute();
        $container->resolve('IoC.Register', 'Sort.File.Output', fn (...$atrs) => $outputPath)->execute();
        $container->resolve('IoC.Register', 'Sort.Type', fn (...$atrs) => $sortCommand)->execute();

        $fileSortCommand = new FileSortCommand($container);
        $fileSortCommand->execute();
    }
)->execute();

return $container;
