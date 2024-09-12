<?php

namespace Tests\GameRecord;

use MyDramGames\Core\GameRecord\GameRecord;
use MyDramGames\Core\GameRecord\GameRecordCollectionPowered;
use PHPUnit\Framework\TestCase;

class GameRecordCollectionPoweredTest extends TestCase
{
    protected GameRecordCollectionPowered $collection;
    protected GameRecord $record;

    public function setUp(): void
    {
        $this->collection = new GameRecordCollectionPowered();
        $this->record = $this->createMock(GameRecord::class);
    }

    public function testAdd(): void
    {
        $this->collection->add($this->record);
        $this->collection->add($this->record);
        $this->assertEquals(2, $this->collection->count());
    }
}
