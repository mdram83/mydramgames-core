<?php

namespace Tests;

use MyDramGames\Core\GameInvite\GameInvite;
use MyDramGames\Core\GameOption\GameOption;
use MyDramGames\Core\GameOption\GameOptionBase;
use MyDramGames\Core\GameOption\GameOptionCollection;
use MyDramGames\Core\GameOption\GameOptionConfigurationCollection;
use MyDramGames\Core\GameOption\GameOptionConfigurationCollectionPowered;
use MyDramGames\Core\GameOption\GameOptionConfigurationGeneric;
use MyDramGames\Core\GameOption\GameOptionType;
use MyDramGames\Core\GameOption\GameOptionValue;
use MyDramGames\Core\GameOption\GameOptionValueCollection;
use MyDramGames\Core\GameOption\Values\GameOptionValueAutostartGeneric;
use MyDramGames\Core\GameOption\Values\GameOptionValueForfeitAfterGeneric;
use MyDramGames\Core\GameOption\Values\GameOptionValueNumberOfPlayersGeneric;
use MyDramGames\Core\GamePlay\GamePlayStorableBase;
use MyDramGames\Core\GamePlay\Services\GamePlayServicesProvider;
use MyDramGames\Core\GamePlay\Storage\GamePlayStorage;
use MyDramGames\Core\GameRecord\GameRecord;
use MyDramGames\Core\GameRecord\GameRecordFactory;
use MyDramGames\Core\GameSetup\GameSetupBase;
use MyDramGames\Utils\Player\Player;

class TestingHelper
{
    public static function getGameOptionBaseClass(
        GameOptionValueCollection $available,
        GameOptionValue $default,
        GameOptionType $type,
    ): GameOption
    {
        return new class($available, $default, $type) extends GameOptionBase implements GameOption
        {
            protected const ?string OPTION_KEY = 'test-key';
            protected const ?string OPTION_NAME = 'test-name';
            protected const ?string OPTION_DESCRIPTION = 'test-description';
            protected const ?string VALUE_CLASS = GameOptionValueAutostartGeneric::class;

            public function __construct(
                GameOptionValueCollection $available,
                GameOptionValueAutostartGeneric $default,
                GameOptionType $type
            )
            {
                parent::__construct($available, $default, $type);
            }
        };
    }

    public static function getGameSetupBaseClass(
        GameOptionCollection $optionsHandler,
        GameOptionValueCollection $valuesHandler,
    ): GameSetupBase
    {
        return new GameSetupBaseTestingStub($optionsHandler, $valuesHandler);
    }

    public static function getGameOptionConfigurations(
        int $numberOfPlayers = 2,
    ): GameOptionConfigurationCollection
    {
        return new GameOptionConfigurationCollectionPowered(null, [
            new GameOptionConfigurationGeneric(
                'numberOfPlayers',
                GameOptionValueNumberOfPlayersGeneric::fromValue($numberOfPlayers)
            ),
            new GameOptionConfigurationGeneric(
                'autostart',
                GameOptionValueAutostartGeneric::Enabled
            ),
            new GameOptionConfigurationGeneric(
                'forfeitAfter',
                GameOptionValueForfeitAfterGeneric::Disabled
            )
        ]);
    }

    public static function getGamePlayStorableBase(
        GamePlayStorage $storage,
        GamePlayServicesProvider $gamePlayServicesProvider,
    ): GamePlayStorableBase
    {
        return new GamePlayStorableTestingStub($storage, $gamePlayServicesProvider);
    }

    public static function getGameRecordFactory(): GameRecordFactory
    {
        return new class() implements GameRecordFactory
        {
            public function create(GameInvite $invite, Player $player, bool $isWinner, array $score): GameRecord
            {
                return new readonly class($invite, $player, $isWinner, $score) implements GameRecord
                {
                    public function __construct(
                        private GameInvite $invite,
                        private Player $player,
                        private bool $isWinner,
                        private array $score,
                    )
                    {

                    }

                    public function getPlayer(): Player
                    {
                        return $this->player;
                    }

                    public function getGameInvite(): GameInvite
                    {
                        return $this->invite;
                    }

                    public function getScore(): array
                    {
                        return $this->score;
                    }

                    public function isWinner(): bool
                    {
                        return $this->isWinner;
                    }
                };
            }
        };
    }
}
