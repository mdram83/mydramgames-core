<?php

namespace Tests\GameInvite;

use MyDramGames\Core\Exceptions\GameInviteException;
use MyDramGames\Core\GameBox\GameBox;
use MyDramGames\Core\GameInvite\GameInviteGeneric;
use MyDramGames\Core\GameOption\GameOptionCollectionPowered;
use MyDramGames\Core\GameOption\GameOptionConfigurationCollection;
use MyDramGames\Core\GameOption\GameOptionConfigurationCollectionPowered;
use MyDramGames\Core\GameOption\GameOptionValueCollectionPowered;
use MyDramGames\Core\GameSetup\GameSetup;
use MyDramGames\Utils\Player\Player;
use MyDramGames\Utils\Player\PlayerCollection;
use MyDramGames\Utils\Player\PlayerCollectionPowered;
use PHPUnit\Framework\TestCase;
use Tests\TestingHelper;

class GameInviteGenericTest extends TestCase
{
    protected GameInviteGeneric $gameInvite;

    protected int|string $id;
    protected GameBox $gameBox;
    protected GameSetup $gameSetup;
    protected GameOptionConfigurationCollection $configurations;
    protected PlayerCollection $players;

    protected Player $playerOne;
    protected Player $playerTwo;
    protected Player $playerThree;

    public function setUp(): void
    {
        $this->playerOne = $this->createMock(Player::class);
        $this->playerTwo = $this->createMock(Player::class);
        $this->playerThree = $this->createMock(Player::class);
        $this->playerOne->method('getId')->willReturn(1);
        $this->playerTwo->method('getId')->willReturn(2);
        $this->playerThree->method('getId')->willReturn(3);

        $this->id = 1;
        $this->gameSetup = $this->getGameSetup();
        $this->configurations = TestingHelper::getGameOptionConfigurations();
        $this->gameBox = $this->createMock(GameBox::class);
        $this->gameBox->method('getGameSetup')->willReturn($this->gameSetup);
        $this->players = new PlayerCollectionPowered();

        $this->gameInvite = $this->getGameInvite();
    }

    protected function getGameSetup(): GameSetup
    {
        return TestingHelper::getGameSetupBaseClass(
            new GameOptionCollectionPowered(),
            new GameOptionValueCollectionPowered(),
        );
    }

    protected function getGameInvite(): GameInviteGeneric
    {
        return new GameInviteGeneric(
            $this->id,
            $this->gameBox,
            $this->configurations,
            $this->players,
        );
    }

    public function testConstructorThrowExceptionWhenGameSetupNotSetUp(): void
    {
        $this->expectException(GameInviteException::class);
        $this->expectExceptionMessage(GameInviteException::MESSAGE_GAME_SETUP_NOT_SET);

        $this->gameSetup = $this->createMock(GameSetup::class);
        $this->gameSetup->method('isSetUp')->willReturn(false);
        $this->gameBox = $this->createMock(GameBox::class);
        $this->gameBox->method('getGameSetup')->willReturn($this->gameSetup);

        $this->getGameInvite();
    }

    public function testConstructorThrowExceptionWhenConfigurationFails(): void
    {
        $this->expectException(GameInviteException::class);
        $this->expectExceptionMessage(GameInviteException::MESSAGE_GAME_SETUP_NOT_SET);

        $this->configurations = new GameOptionConfigurationCollectionPowered();
        $this->getGameInvite();
    }

    public function testContructorThrowExceptionWhenIdIsEmptyString(): void
    {
        $this->expectException(GameInviteException::class);
        $this->expectExceptionMessage(GameInviteException::MESSAGE_GAME_NOT_FOUND);

        $this->id = '';
        $this->gameSetup = $this->getGameSetup();
        $this->getGameInvite();
    }

    public function testConstructor(): void
    {
        $this->assertInstanceOf(GameInviteGeneric::class, $this->gameInvite);
    }

    public function testGetId(): void
    {
        $this->assertSame($this->id, $this->gameInvite->getId());
    }

    public function testGetGameBox(): void
    {
        $this->assertSame($this->gameBox, $this->gameInvite->getGameBox());
    }

    public function testGetGameSetup(): void
    {
        $this->assertSame($this->gameSetup, $this->gameInvite->getGameSetup());
    }

    public function testAddPlayerThrowExceptionWhenTooManyPlayers(): void
    {
        $this->expectException(GameInviteException::class);
        $this->expectExceptionMessage(GameInviteException::MESSAGE_TOO_MANY_PLAYERS);

        $this->gameInvite->addPlayer($this->playerOne, true);
        $this->gameInvite->addPlayer($this->playerTwo);
        $this->gameInvite->addPlayer($this->playerThree);
    }

    public function testAddPlayerThrowExceptionWhenSamePlayerManyTimes(): void
    {
        $this->expectException(GameInviteException::class);
        $this->expectExceptionMessage(GameInviteException::MESSAGE_PLAYER_ALREADY_ADDED);

        $this->gameInvite->addPlayer($this->playerOne, true);
        $this->gameInvite->addPlayer($this->playerOne);
    }

    public function testAddPlayerThrowExceptionWhenAddingHostMoreThenOnce(): void
    {
        $this->expectException(GameInviteException::class);
        $this->expectExceptionMessage(GameInviteException::MESSAGE_HOST_ALREADY_ADDED);

        $this->gameInvite->addPlayer($this->playerOne, true);
        $this->gameInvite->addPlayer($this->playerTwo, true);
    }

    public function testAddPlayerThrowExceptionWhenAddingPlayerToGameWithoutHost(): void
    {
        $this->expectException(GameInviteException::class);
        $this->expectExceptionMessage(GameInviteException::MESSAGE_HOST_NOT_SET);

        $this->gameInvite->addPlayer($this->playerOne, false);
    }

    public function testAddPlayerGetPlayerIsPlayer()
    {
        $this->gameInvite->addPlayer($this->playerOne, true);
        $this->gameInvite->addPlayer($this->playerTwo, false);

        $this->assertTrue($this->gameInvite->isPlayer($this->playerOne));
        $this->assertTrue($this->gameInvite->isPlayer($this->playerTwo));
        $this->assertFalse($this->gameInvite->isPlayer($this->playerThree));
    }

    public function testGetHostThrowExceptionWhenHostNotSet(): void
    {
        $this->expectException(GameInviteException::class);
        $this->expectExceptionMessage(GameInviteException::MESSAGE_HOST_NOT_SET);

        $this->gameInvite->getHost();
    }

    public function testIsHostThrowExceptionWhenHostNotSet(): void
    {
        $this->expectException(GameInviteException::class);
        $this->expectExceptionMessage(GameInviteException::MESSAGE_HOST_NOT_SET);

        $this->gameInvite->isHost($this->playerOne);
    }

    public function testGetHostIsHost(): void
    {
        $this->gameInvite->addPlayer($this->playerOne, true);
        $this->gameInvite->addPlayer($this->playerTwo, false);

        $this->assertTrue($this->gameInvite->isHost($this->playerOne));
        $this->assertFalse($this->gameInvite->isHost($this->playerTwo));
    }

    public function testGetPlayers(): void
    {
        $emptyPlayers = $this->gameInvite->getPlayers()->clone();

        $this->gameInvite->addPlayer($this->playerOne, true);
        $this->gameInvite->addPlayer($this->playerTwo, false);
        $players = $this->gameInvite->getPlayers();

        $this->assertEquals(0, $emptyPlayers->count());
        $this->assertEquals(2, $players->count());
        $this->assertTrue($players->exist($this->playerOne->getId()));
        $this->assertTrue($players->exist($this->playerTwo->getId()));
    }

    public function testToArray(): void
    {
        $this->gameInvite->addPlayer($this->playerOne, true);
        $this->gameInvite->addPlayer($this->playerTwo);

        $expected = [
            'id' => $this->gameInvite->getId(),
            'host' => ['name' => $this->gameInvite->getHost()->getName()],
            'options' => array_map(fn($option) => $option->getConfiguredValue(), $this->gameInvite->getGameSetup()->getAllOptions()->toArray()),
            'players' => array_map(fn($player) => ['name' => $player->getName()], $this->gameInvite->getPlayers()->toArray()),
        ];

        $this->assertEquals($expected, $this->gameInvite->toArray());
    }
}
