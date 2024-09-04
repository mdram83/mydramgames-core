<?php

namespace Tests\GameOption;

use MyDramGames\Core\GameOption\GameOptionConfiguration;
use MyDramGames\Core\GameOption\GameOptionConfigurationCollectionPowered;
use MyDramGames\Utils\Exceptions\CollectionException;
use PHPUnit\Framework\TestCase;

class GameOptionConfigurationCollectionPoweredTest extends TestCase
{
    protected GameOptionConfigurationCollectionPowered $collection;
    protected GameOptionConfiguration $configuration;

    public function setUp(): void
    {
        $this->collection = new GameOptionConfigurationCollectionPowered();
        $this->configuration = $this->createMock(GameOptionConfiguration::class);
        $this->configuration->method('getGameOptionKey')->willReturn('test-key');
    }

    public function testAddThrowExceptionForDuplicateItem(): void
    {
        $this->expectException(CollectionException::class);
        $this->expectExceptionMessage(CollectionException::MESSAGE_DUPLICATE);

        $this->collection->add($this->configuration);
        $this->collection->add($this->configuration);
    }

    public function testAdd(): void
    {
        $this->collection->add($this->configuration);
        $this->assertEquals(1, $this->collection->count());
    }
}
