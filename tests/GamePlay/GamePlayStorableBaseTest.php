<?php

namespace Tests\GamePlay;

use MyDramGames\Core\Exceptions\GamePlayException;
use MyDramGames\Core\Exceptions\GamePlayStorageException;
use MyDramGames\Core\GameInvite\GameInvite;
use MyDramGames\Core\GameMove\GameMove;
use MyDramGames\Core\GameOption\GameOptionCollectionPowered;
use MyDramGames\Core\GameOption\GameOptionValueCollectionPowered;
use MyDramGames\Core\GamePlay\GamePlay;
use MyDramGames\Core\GamePlay\GamePlayStorableBase;
use MyDramGames\Core\GamePlay\Services\GamePlayServicesProvider;
use MyDramGames\Core\GamePlay\Services\GamePlayServicesProviderGeneric;
use MyDramGames\Core\GamePlay\Storage\GamePlayStorage;
use MyDramGames\Core\GamePlay\Storage\GamePlayStorageInMemory;
use MyDramGames\Core\GameSetup\GameSetup;
use MyDramGames\Utils\Php\Collection\CollectionEnginePhpArray;
use MyDramGames\Utils\Player\Player;
use MyDramGames\Utils\Player\PlayerCollection;
use MyDramGames\Utils\Player\PlayerCollectionPowered;
use PHPUnit\Framework\TestCase;
use Tests\TestingHelper;

class GamePlayStorableBaseTest extends TestCase
{
    protected GamePlayStorableBase $play;
    protected GamePlayStorage $storage;
    protected GamePlayServicesProvider $provider;
    protected GameInvite $invite;
    protected GameSetup $setup;

    protected GameMove $move;
    protected PlayerCollection $players;
    protected Player $playerOne;
    protected Player $playerTwo;

    public function setUp(): void
    {
        $this->playerOne = $this->getPlayerMock(1, 'Player 1');
        $this->playerTwo = $this->getPlayerMock(2, 'Player 2');
        $this->players = new PlayerCollectionPowered(null, [$this->playerOne, $this->playerTwo]);

        $this->move = $this->getMoveFor($this->playerTwo);

        $this->setup = TestingHelper::getGameSetupBaseClass(
            new GameOptionCollectionPowered(),
            new GameOptionValueCollectionPowered(),
        );
        $this->setup->configureOptions(TestingHelper::getGameOptionConfigurations());

        $this->invite = $this->createMock(GameInvite::class);
        $this->invite->method('getPlayers')->willReturn($this->players);
        $this->invite->method('getGameSetup')->willReturn($this->setup);

        $this->storage = new GamePlayStorageInMemory($this->invite);
        $this->provider = new GamePlayServicesProviderGeneric(
            new CollectionEnginePhpArray(),
            new PlayerCollectionPowered(),
        );

        $this->play = TestingHelper::getGamePlayStorableBase($this->storage, $this->provider);
    }

    protected function getPlayerMock(int|string $id, string $name): Player
    {
        $player = $this->createMock(Player::class);
        $player->method('getId')->willReturn($id);
        $player->method('getName')->willReturn($name);

        return $player;
    }

    protected function getMoveFor(Player $player): GameMove
    {
        $move = $this->createMock(GameMove::class);
        $move->method('getDetails')->willReturn(['word' => 'Word-x']);
        $move->method('getPlayer')->willReturn($player);

        return $move;
    }

    public function testContructorThrowExceptionIfStorageHasNoGameInvite(): void
    {
        $this->expectException(GamePlayException::class);
        $this->expectExceptionMessage(GamePlayException::MESSAGE_STORAGE_INCORRECT);

        $storage = $this->createMock(GamePlayStorage::class);
        $storage->method('getGameInvite')->willThrowException(new GamePlayStorageException());

        TestingHelper::getGamePlayStorableBase($storage, $this->provider);
    }

    public function testConstructorThrowExceptionIfStorageGameInviteHasWrongNumberOfPlayers(): void
    {
        $this->expectException(GamePlayException::class);
        $this->expectExceptionMessage(GamePlayException::MESSAGE_MISSING_PLAYERS);

        $storage = $this->createMock(GamePlayStorage::class);

        TestingHelper::getGamePlayStorableBase($storage, $this->provider);
    }

    public function testConstructorWithStorageAlreadySetUp(): void
    {
        $this->play->handleMove($this->move);
        $setup = $this->storage->getSetup();
        $play = TestingHelper::getGamePlayStorableBase($this->storage, $this->provider);

        $this->assertTrue($setup);
        $this->assertInstanceOf(GamePlay::class, $play);
    }

    public function testConstructor(): void
    {
        $this->assertSame($this->playerTwo, $this->play->getActivePlayer());
    }

    public function testGetId(): void
    {
        $this->assertEquals(1, $this->play->getId());
    }

    public function testGetPlayers(): void
    {
        $players = $this->play->getPlayers();
        $this->assertSame($this->players->getOne(1), $players->getOne(1));
        $this->assertSame($this->players->getOne(2), $players->getOne(2));
        $this->assertSame($this->players->count(), $players->count());
    }

    public function testGetGameInvite(): void
    {
        $this->assertSame($this->invite, $this->play->getGameInvite());
    }

    public function testIsFinished(): void
    {
        $notFinished = $this->play->isFinished();
        $this->play->handleForfeit($this->playerOne);

        $this->assertFalse($notFinished);
        $this->assertTrue($this->play->isFinished());
    }

    // TODO continue with next Traits testing
}
