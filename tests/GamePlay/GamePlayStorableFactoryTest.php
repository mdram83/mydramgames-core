<?php

namespace Tests\GamePlay;

use MyDramGames\Core\GameInvite\GameInvite;
use MyDramGames\Core\GameOption\GameOptionCollectionPowered;
use MyDramGames\Core\GameOption\GameOptionValueCollectionPowered;
use MyDramGames\Core\GamePlay\GamePlay;
use MyDramGames\Core\GamePlay\GamePlayStorableFactory;
use MyDramGames\Core\GamePlay\Services\GamePlayServicesProvider;
use MyDramGames\Core\GamePlay\Services\GamePlayServicesProviderGeneric;
use MyDramGames\Core\GamePlay\Storage\GamePlayStorage;
use MyDramGames\Core\GamePlay\Storage\GamePlayStorageFactoryInMemory;
use MyDramGames\Core\GamePlay\Storage\GamePlayStorageInMemory;
use MyDramGames\Core\GameRecord\GameRecordCollectionPowered;
use MyDramGames\Core\GameRecord\GameRecordFactory;
use MyDramGames\Core\GameSetup\GameSetup;
use MyDramGames\Utils\Php\Collection\CollectionEnginePhpArray;
use MyDramGames\Utils\Player\Player;
use MyDramGames\Utils\Player\PlayerCollection;
use MyDramGames\Utils\Player\PlayerCollectionPowered;
use PHPUnit\Framework\TestCase;
use Tests\GamePlayStorableTestingStub;
use Tests\TestingHelper;

class GamePlayStorableFactoryTest extends TestCase
{
    protected GameInvite $invite;
    protected GamePlayServicesProvider $provider;
    protected string $gamePlayClassname;

    public function setUp(): void
    {
        $players = new PlayerCollectionPowered(null, [
            $this->getPlayerMock(1, 'Player 1'),
            $this->getPlayerMock(2, 'Player 2'),
        ]);

        $setup = TestingHelper::getGameSetupBaseClass(
            new GameOptionCollectionPowered(),
            new GameOptionValueCollectionPowered(),
        );
        $setup->configureOptions(TestingHelper::getGameOptionConfigurations());

        $this->invite = $this->createMock(GameInvite::class);
        $this->invite->method('getPlayers')->willReturn($players);
        $this->invite->method('getGameSetup')->willReturn($setup);

        $this->provider = new GamePlayServicesProviderGeneric(
            new CollectionEnginePhpArray(),
            new PlayerCollectionPowered(),
            $this->createMock(GameRecordFactory::class),
            new GameRecordCollectionPowered(),
        );

        $this->gamePlayClassname = GamePlayStorableTestingStub::class;
    }

    protected function getPlayerMock(int|string $id, string $name): Player
    {
        $player = $this->createMock(Player::class);
        $player->method('getId')->willReturn($id);
        $player->method('getName')->willReturn($name);

        return $player;
    }

    public function testCreate(): void
    {
        $factory = new GamePlayStorableFactory(
            new GamePlayStorageFactoryInMemory(),
            $this->provider,
        );

        $this->assertInstanceOf(GamePlay::class, $factory->create($this->gamePlayClassname, $this->invite));
    }
}
