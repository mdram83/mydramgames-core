<?php

namespace Tests\GameIndex;

use MyDramGames\Core\GameBox\GameBox;
use MyDramGames\Core\GameIndex\GameIndexStorableBase;
use MyDramGames\Core\GameInvite\GameInvite;
use MyDramGames\Core\GameMove\GameMove;
use MyDramGames\Core\GameOption\GameOptionCollectionPowered;
use MyDramGames\Core\GameOption\GameOptionValueCollectionPowered;
use MyDramGames\Core\GamePlay\GamePlay;
use MyDramGames\Core\GamePlay\Services\GamePlayServicesProviderGeneric;
use MyDramGames\Core\GamePlay\Storage\GamePlayStorageFactoryInMemory;
use MyDramGames\Core\GameRecord\GameRecordCollectionPowered;
use MyDramGames\Core\GameSetup\GameSetup;
use MyDramGames\Utils\Php\Collection\CollectionEnginePhpArray;
use MyDramGames\Utils\Player\Player;
use MyDramGames\Utils\Player\PlayerCollectionPowered;
use PHPUnit\Framework\MockObject\Generator\Generator as MockGenerator;
use PHPUnit\Framework\TestCase;
use Tests\TestingHelper;

class GameIndexStorableBaseTest extends TestCase
{
    protected GameIndexStorableBase $index;

    public function setUp(): void
    {
        $this->index = $this->getGameIndex();
    }

    protected function getGameIndex(): GameIndexStorableBase
    {
        return new class(
            new GameOptionCollectionPowered(),
            new GameOptionValueCollectionPowered(),
            new GamePlayStorageFactoryInMemory(),
            new GamePlayServicesProviderGeneric(
                new CollectionEnginePhpArray(),
                new PlayerCollectionPowered(),
                TestingHelper::getGameRecordFactory(),
                new GameRecordCollectionPowered()
            ),
        ) extends GameIndexStorableBase {

            public const string SLUG = 'overwritten-slug';

            public function getGameSetup(): GameSetup
            {
                return TestingHelper::getGameSetupBaseClass(
                    new GameOptionCollectionPowered(),
                    new GameOptionValueCollectionPowered(),
                );
            }

            public function createGameMove(Player $player, array $inputs): GameMove
            {
                $mock = (new MockGenerator())->testDouble(
                    GameMove::class,
                    true,
                    true,
                    callOriginalConstructor: false,
                    callOriginalClone: false,
                    cloneArguments: false,
                    allowMockingUnknownTypes: false,
                );
                assert($mock instanceof GameMove);
                return $mock;
            }

            public function createGamePlay(GameInvite $gameInvite): GamePlay
            {
                $mock = (new MockGenerator())->testDouble(
                    GamePlay::class,
                    true,
                    true,
                    callOriginalConstructor: false,
                    callOriginalClone: false,
                    cloneArguments: false,
                    allowMockingUnknownTypes: false,
                );
                assert($mock instanceof GamePlay);
                return $mock;
            }

            protected function configureGameIndex(): void
            {

            }
        };
    }

    public function testConstructor(): void
    {
        $this->assertInstanceOf(GameIndexStorableBase::class, $this->index);
    }

    public function testGetSlug(): void
    {
        $this->assertIsString($this->index->getSlug());
        $this->assertEquals('overwritten-slug', $this->index->getSlug());
    }

    public function testGetGameBox(): void
    {
        $this->assertInstanceOf(GameBox::class, $this->index->getGameBox());
        $this->assertTrue($this->index->getGameBox(true, null)->isActive());
        $this->assertTrue($this->index->getGameBox(null, true)->isPremium());
        $this->assertFalse($this->index->getGameBox(false, null)->isActive());
        $this->assertFalse($this->index->getGameBox(null, false)->isPremium());
    }
}
