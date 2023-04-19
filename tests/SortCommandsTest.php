<?php

require_once $_SERVER['DOCUMENT_ROOT'] . 'vendor/autoload.php';

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use App\Sort\InsertionSortCommand;
use App\Sort\MergeSortCommand;
use App\Sort\SelectionSortCommand;
use App\Sort\Sortable;

final class SortCommandsTest extends TestCase
{
    const INITIAL_LIST = [1, 7, 75, 0];
    const EXPECTED_LIST = [0, 1, 7, 75];

    private Sortable&MockObject $sortableMock;

    public function testInsertionSort(): void
    {
        $testcase = $this;
        $this->sortableMock->method('setData')->willReturnCallback(function (array $items) use ($testcase) {
            $testcase->assertSame($items, $testcase::EXPECTED_LIST, 'Ошибка сортировки');
        });

        $moveCommand = new InsertionSortCommand($this->sortableMock);
        $moveCommand->execute();
    }

    public function testMergeSort(): void
    {
        $testcase = $this;
        $this->sortableMock->method('setData')->willReturnCallback(function (array $items) use ($testcase) {
            $testcase->assertSame($items, $testcase::EXPECTED_LIST, 'Ошибка сортировки');
        });

        $moveCommand = new MergeSortCommand($this->sortableMock);
        $moveCommand->execute();
    }

    public function testSelectionInsertionSort(): void
    {
        $testcase = $this;
        $this->sortableMock->method('setData')->willReturnCallback(function (array $items) use ($testcase) {
            $testcase->assertSame($items, $testcase::EXPECTED_LIST, 'Ошибка сортировки');
        });

        $moveCommand = new SelectionSortCommand($this->sortableMock);
        $moveCommand->execute();
    }

    protected function setUp(): void
    {
        /** @var Sortable&MockObject $sortableMock */
        $this->sortableMock = $this->createMock(Sortable::class);
        $this->sortableMock->method('getData')->willReturn(self::INITIAL_LIST);
    }
}
