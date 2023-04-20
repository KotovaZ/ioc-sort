<?php

require_once $_SERVER['DOCUMENT_ROOT'] . 'vendor/autoload.php';

use App\Exceptions\NotFoundException;
use App\Interfaces\Command;
use App\IoC\IoC;
use App\Sort\FileSortCommand;
use App\Sort\Sortable;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;


final class FileSortCommandTest extends TestCase
{
    private IoC $factory;

    public function testMacroCommandWorksCorrectly(): void
    {
        /** @var Command&MockObject $fileReadCommandMock */
        $fileReadCommandMock = $this->createMock(Command::class);
        $fileReadCommandMock->expects($this->once())->method('execute');

        /** @var Command&MockObject $fileWriteCommandMock */
        $fileWriteCommandMock = $this->createMock(Command::class);
        $fileWriteCommandMock->expects($this->once())->method('execute');

        /** @var Command&MockObject $sortCommand */
        $sortCommand = $this->createMock(Command::class);
        $sortCommand->expects($this->once())->method('execute');

        /** @var Sortable&MockObject $sortableMock */
        $sortableMock = $this->createMock(Sortable::class);

        $self = $this;

        $this->factory->resolve(
            'IoC.Register',
            'Sortable',
            fn (...$attrs) => $sortableMock
        )->execute();


        $this->factory->resolve(
            'IoC.Register',
            'IO.File.Read',
            function (...$attrs) use ($self, $fileReadCommandMock) {
                $self->assertIsString($attrs[0]);
                $self->assertInstanceOf(Sortable::class, $attrs[1]);
                return $fileReadCommandMock;
            }
        )->execute();

        $this->factory->resolve(
            'IoC.Register',
            'IO.File.Write',
            function (...$attrs) use ($self, $fileWriteCommandMock) {
                $self->assertIsString($attrs[0]);
                $self->assertInstanceOf(Sortable::class, $attrs[1]);
                return $fileWriteCommandMock;
            }
        )->execute();

        $this->factory->resolve(
            'IoC.Register',
            'Command.Sort.Test',
            function (...$attrs) use ($self, $sortCommand) {
                $self->assertInstanceOf(Sortable::class, $attrs[0]);
                return $sortCommand;
            }
        )->execute();

        $fileSortCommand = new FileSortCommand($this->factory);
        $fileSortCommand->execute();
    }

    protected function setUp(): void
    {
        $this->factory = new IoC;
        $this->factory->resolve('IoC.Register', 'Sort.File.Input', fn (...$atrs) => 'data/input')->execute();
        $this->factory->resolve('IoC.Register', 'Sort.File.Output', fn (...$atrs) => 'data/output')->execute();
        $this->factory->resolve('IoC.Register', 'Sort.Type', fn (...$atrs) => 'Command.Sort.Test')->execute();
    }
}
