<?php

namespace Tests\GameOption;

use MyDramGames\Core\GameOption\GameOptionValue;
use MyDramGames\Core\GameOption\GameOptionValueCollection;
use MyDramGames\Core\GameOption\GameOptionValueCollectionPowered;
use MyDramGames\Utils\Exceptions\CollectionException;
use PHPUnit\Framework\TestCase;

class GameOptionValueCollectionPoweredTest extends TestCase
{
    private GameOptionValueCollectionPowered $collection;
    private GameOptionValue $valueOne;
    private GameOptionValue $valueTwo;
    private GameOptionValue $valueThree;
    private array $initialValues;

    public function setUp(): void
    {
        $this->valueOne = $this->createMock(GameOptionValue::class);
        $this->valueTwo = $this->createMock(GameOptionValue::class);
        $this->valueThree = $this->createMock(GameOptionValue::class);

        $this->initialValues = [$this->valueOne, $this->valueTwo];
        $this->collection = new GameOptionValueCollectionPowered(null, $this->initialValues);
    }

    public function testInterface(): void
    {
        $this->assertInstanceOf(GameOptionValueCollection::class, $this->collection);
    }

    public function testAddThrowExceptionForNotGameOptionValueItems(): void
    {
        $this->expectException(CollectionException::class);
        $this->collection->add('incompatible-object-type');
    }

    public function testAdd(): void
    {
        $this->collection->add($this->valueThree);
        $this->assertEquals(count($this->initialValues) + 1, $this->collection->count());
    }

    public function testAddAllowsForDuplicates(): void
    {
        $this->collection->add($this->valueThree);
        $this->collection->add($this->valueThree);
        $this->assertEquals(count($this->initialValues) + 2, $this->collection->count());
    }
}
