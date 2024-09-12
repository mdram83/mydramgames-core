<?php

namespace Tests\GameResult;

use MyDramGames\Core\GameInvite\GameInvite;
use MyDramGames\Core\GameRecord\GameRecordCollection;
use MyDramGames\Core\GameRecord\GameRecordFactory;
use MyDramGames\Core\GameResult\GameResult;
use MyDramGames\Core\GameResult\GameResultProviderBase;
use PHPUnit\Framework\TestCase;

class GameResultProviderBaseTest extends TestCase
{
    protected GameResultProviderBase $provider;

    public function setUp(): void
    {
        $this->provider = new class(
            $this->createMock(GameRecordFactory::class),
            $this->createMock(GameRecordCollection::class),
        ) extends GameResultProviderBase
        {
            public function getResult(mixed $data): ?GameResult
            {
                return null;
            }

            public function createGameRecords(GameInvite $gameInvite): GameRecordCollection
            {
                return $this->gameRecordCollection;
            }
        };
    }

    public function testConstructor(): void
    {
        $this->assertInstanceOf(GameResultProviderBase::class, $this->provider);
    }
}
