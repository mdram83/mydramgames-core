<?php

namespace Tests\GameIndex;

use MyDramGames\Core\GameIndex\GameIndex;
use MyDramGames\Core\GameIndex\GameIndexCollectionPowered;
use MyDramGames\Utils\Exceptions\CollectionException;
use PHPUnit\Framework\TestCase;

class GameIndexCollectionPoweredTest extends TestCase
{
    protected GameIndexCollectionPowered $collection;
    protected GameIndex $gameIndex;

    public function setUp(): void
    {
        $this->collection = new GameIndexCollectionPowered();
        $this->gameIndex = $this->createMock(GameIndex::class);
        $this->gameIndex->method('getSlug')->willReturn('test-slug');
    }

    public function testAddThrowExceptionForDuplicateItem(): void
    {
        $this->expectException(CollectionException::class);
        $this->expectExceptionMessage(CollectionException::MESSAGE_DUPLICATE);

        $this->collection->add($this->gameIndex);
        $this->collection->add($this->gameIndex);
    }

    public function testAdd(): void
    {
        $this->collection->add($this->gameIndex);
        $this->assertEquals(1, $this->collection->count());
    }
}
