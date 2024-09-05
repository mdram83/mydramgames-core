<?php

namespace Tests\GameBox;

use MyDramGames\Core\GameBox\GameBox;
use MyDramGames\Core\GameBox\GameBoxCollectionPowered;
use MyDramGames\Utils\Exceptions\CollectionException;
use PHPUnit\Framework\TestCase;

class GameBoxCollectionPoweredTest extends TestCase
{
    protected GameBoxCollectionPowered $collection;
    protected GameBox $gameBox;

    public function setUp(): void
    {
        $this->collection = new GameBoxCollectionPowered();
        $this->gameBox = $this->createMock(GameBox::class);
        $this->gameBox->method('getSlug')->willReturn('test-slug');
    }

    public function testAddThrowExceptionForDuplicateItem(): void
    {
        $this->expectException(CollectionException::class);
        $this->expectExceptionMessage(CollectionException::MESSAGE_DUPLICATE);

        $this->collection->add($this->gameBox);
        $this->collection->add($this->gameBox);
    }

    public function testAdd(): void
    {
        $this->collection->add($this->gameBox);
        $this->assertEquals(1, $this->collection->count());
    }
}
