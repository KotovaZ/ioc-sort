<?php

require_once $_SERVER['DOCUMENT_ROOT'] . 'vendor/autoload.php';

use App\Exceptions\NotFoundException;
use App\Interfaces\Command;
use App\IoC\IoC;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;


final class FactoryTest extends TestCase
{
    private IoC $factory;

    public function testRegistrationMethodAvailable(): void
    {
        $registerCommand = $this->factory->resolve(
            'IoC.Register',
            'Test',
            fn (...$attrs) => false
        );

        $this->assertInstanceOf(Command::class, $registerCommand);
    }

    public function testDependencyRegistration(): void
    {
        /** @var Command&MockObject $commandMock */
        $commandMock = $this->createMock(Command::class);

        $this->factory->resolve(
            'IoC.Register',
            'Test',
            fn (...$attrs) => $commandMock
        )->execute();

        $this->assertEquals($commandMock, $this->factory->resolve('Test'));
    }

    public function testUndefinedDependencyException(): void
    {
        $this->expectException(NotFoundException::class);
        $this->factory->resolve('SomeObject');
    }

    protected function setUp(): void
    {
        $this->factory = new IoC;
    }
}
