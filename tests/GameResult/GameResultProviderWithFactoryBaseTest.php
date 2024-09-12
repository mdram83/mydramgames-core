<?php

namespace Tests\GameResult;

use MyDramGames\Core\GameInvite\GameInvite;
use MyDramGames\Core\GameRecord\GameRecordCollection;
use MyDramGames\Core\GameRecord\GameRecordCollectionPowered;
use MyDramGames\Core\GameRecord\GameRecordFactory;
use MyDramGames\Core\GameResult\GameResult;
use MyDramGames\Core\GameResult\GameResultProviderWithFactoryBase;
use PHPUnit\Framework\TestCase;

class GameResultProviderWithFactoryBaseTest extends TestCase
{
    protected GameResultProviderWithFactoryBase $provider;

    public function setUp(): void
    {
        $this->provider = new class(
            $this->createMock(GameRecordFactory::class)
        ) extends GameResultProviderWithFactoryBase
        {
            public function getResult(mixed $data): ?GameResult
            {
                return null;
            }

            public function createGameRecords(GameInvite $gameInvite): GameRecordCollection
            {
                return new GameRecordCollectionPowered();
            }
        };
    }

    public function testConstructor(): void
    {
        $this->assertInstanceOf(GameResultProviderWithFactoryBase::class, $this->provider);
    }
}
