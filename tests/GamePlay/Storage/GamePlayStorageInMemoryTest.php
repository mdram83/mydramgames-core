<?php

namespace Tests\GamePlay\Storage;

use MyDramGames\Core\Exceptions\GamePlayStorageException;
use MyDramGames\Core\GameInvite\GameInvite;
use MyDramGames\Core\GamePlay\Storage\GamePlayStorageInMemory;
use PHPUnit\Framework\TestCase;

class GamePlayStorageInMemoryTest extends TestCase
{
    protected GamePlayStorageInMemory $storage;
    protected GameInvite $gameInvite;
    protected array $gameData;

    public function setUp(): void
    {
        $this->gameInvite = $this->createMock(GameInvite::class);
        $this->gameData = ['test-data-1', 'test-data-2'];
        $this->storage = $this->getGamePlayStorage();
    }

    public function getGamePlayStorage(): GamePlayStorageInMemory
    {
        return new GamePlayStorageInMemory($this->gameInvite);
    }

    public function testGetId(): void
    {
        $this->assertEquals(1, $this->storage->getId());
    }

    public function testSetGameInviteThrowExceptionIfAlreadySet(): void
    {
        $this->expectException(GamePlayStorageException::class);
        $this->expectExceptionMessage(GamePlayStorageException::MESSAGE_INVALID_INVITE);

        $this->storage->setGameInvite($this->gameInvite);
    }

    public function testGetGameInvite(): void
    {
        $this->assertSame($this->gameInvite, $this->storage->getGameInvite());
    }

    public function testSetGameDataThrowExceptionWhenGameIsFinished(): void
    {
        $this->expectException(GamePlayStorageException::class);
        $this->expectExceptionMessage(GamePlayStorageException::MESSAGE_FINISH_ALREADY_SET);

        $this->storage->setFinished();
        $this->storage->setGameData([]);
    }

    public function testGetGameData(): void
    {
        $this->storage->setGameData($this->gameData);
        $this->assertSame($this->gameData, $this->storage->getGameData());
    }

    public function testSetSetupThrowExceptionWhenDoneTwice(): void
    {
        $this->expectException(GamePlayStorageException::class);
        $this->expectExceptionMessage(GamePlayStorageException::MESSAGE_SETUP_ALREADY_SET);

        $this->storage->setSetup();
        $this->storage->setSetup();
    }

    public function testGetSetupFalse(): void
    {
        $this->assertFalse($this->storage->getSetup());
    }

    public function testGetSetupTrue(): void
    {
        $this->storage->setSetup();
        $this->assertTrue($this->storage->getSetup());
    }

    public function testSetFinishedThrowExcetionWhenAlreadyFinished(): void
    {
        $this->expectException(GamePlayStorageException::class);
        $this->expectExceptionMessage(GamePlayStorageException::MESSAGE_FINISH_ALREADY_SET);

        $this->storage->setFinished();
        $this->storage->setFinished();
    }

    public function testGetFinishedFalse(): void
    {
        $this->assertFalse($this->storage->getFinished());
    }

    public function testGetFinishedTrue(): void
    {
        $this->storage->setFinished();
        $this->assertTrue($this->storage->getFinished());
    }
}
