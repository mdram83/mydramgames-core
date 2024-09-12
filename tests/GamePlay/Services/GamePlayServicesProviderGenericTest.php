<?php

namespace Tests\GamePlay\Services;

use MyDramGames\Core\GamePlay\Services\GamePlayServicesProviderGeneric;
use MyDramGames\Core\GameRecord\GameRecord;
use MyDramGames\Core\GameRecord\GameRecordCollection;
use MyDramGames\Core\GameRecord\GameRecordCollectionPowered;
use MyDramGames\Core\GameRecord\GameRecordFactory;
use MyDramGames\Utils\Php\Collection\CollectionEngine;
use MyDramGames\Utils\Php\Collection\CollectionEnginePhpArray;
use MyDramGames\Utils\Player\Player;
use MyDramGames\Utils\Player\PlayerCollection;
use MyDramGames\Utils\Player\PlayerCollectionPowered;
use PHPUnit\Framework\TestCase;

class GamePlayServicesProviderGenericTest extends TestCase
{
    protected GamePlayServicesProviderGeneric $provider;
    protected CollectionEngine $collectionEngine;
    protected PlayerCollection $playerCollection;
    protected GameRecordFactory $gameRecordFactory;
    protected GameRecordCollection $gameRecordCollection;

    public function setUp(): void
    {
        $this->collectionEngine = new CollectionEnginePhpArray();
        $this->playerCollection = new PlayerCollectionPowered();
        $this->gameRecordFactory = $this->createMock(GameRecordFactory::class);
        $this->gameRecordCollection = new GameRecordCollectionPowered();

        $this->provider = new GamePlayServicesProviderGeneric(
            $this->collectionEngine,
            $this->playerCollection,
            $this->gameRecordFactory,
            $this->gameRecordCollection,
        );
    }

    public function testGetCollectionEngine(): void
    {
        $this->collectionEngine->add(1);
        $engine = $this->provider->getCollectionEngine();

        $this->assertEquals(1, $this->collectionEngine->count());
        $this->assertTrue($engine->isEmpty());
    }

    public function testGetPlayerCollection(): void
    {
        $player = $this->createMock(Player::class);
        $player->method('getId')->willReturn(1);
        $this->playerCollection->add($player);
        $playerCollection = $this->provider->getPlayerCollection();

        $this->assertEquals(1, $this->playerCollection->count());
        $this->assertTrue($playerCollection->isEmpty());
    }

    public function testGetGameRecordFactory(): void
    {
        $this->assertInstanceOf(GameRecordFactory::class, $this->provider->getGameRecordFactory());
    }

    public function testGetGameRecordCollection(): void
    {
        $record = $this->createMock(GameRecord::class);
        $this->gameRecordCollection->add($record);
        $gameRecordCollection = $this->provider->getGameRecordCollection();

        $this->assertEquals(1, $this->gameRecordCollection->count());
        $this->assertTrue($gameRecordCollection->isEmpty());
    }
}
