<?php

namespace Tests\GameOption;

use MyDramGames\Core\GameOption\GameOption;
use MyDramGames\Core\GameOption\GameOptionCollectionPowered;
use MyDramGames\Utils\Exceptions\CollectionException;
use PHPUnit\Framework\TestCase;

class GameOptionCollectionPoweredTest extends TestCase
{
    protected GameOptionCollectionPowered $collection;
    protected GameOption $option;

    public function setUp(): void
    {
        $this->collection = new GameOptionCollectionPowered();
        $this->option = $this->createMock(GameOption::class);
        $this->option->method('getKey')->willReturn('test-key');
    }

    public function testAddThrowExceptionForDuplicateItem(): void
    {
        $this->expectException(CollectionException::class);
        $this->expectExceptionMessage(CollectionException::MESSAGE_DUPLICATE);

        $this->collection->add($this->option);
        $this->collection->add($this->option);
    }

    public function testAdd(): void
    {
        $this->collection->add($this->option);
        $this->assertEquals(1, $this->collection->count());
    }
}
