<?php

namespace Tests;

use MyDramGames\Core\GameInvite\GameInvite;
use MyDramGames\Core\GameMove\GameMove;
use MyDramGames\Core\GameOption\GameOption;
use MyDramGames\Core\GameOption\GameOptionBase;
use MyDramGames\Core\GameOption\GameOptionCollection;
use MyDramGames\Core\GameOption\GameOptionConfigurationCollection;
use MyDramGames\Core\GameOption\GameOptionConfigurationCollectionPowered;
use MyDramGames\Core\GameOption\GameOptionConfigurationGeneric;
use MyDramGames\Core\GameOption\GameOptionType;
use MyDramGames\Core\GameOption\GameOptionTypeGeneric;
use MyDramGames\Core\GameOption\GameOptionValue;
use MyDramGames\Core\GameOption\GameOptionValueCollection;
use MyDramGames\Core\GameOption\Options\GameOptionAutostartGeneric;
use MyDramGames\Core\GameOption\Options\GameOptionForfeitAfterGeneric;
use MyDramGames\Core\GameOption\Options\GameOptionNumberOfPlayersGeneric;
use MyDramGames\Core\GameOption\Values\GameOptionValueAutostartGeneric;
use MyDramGames\Core\GameOption\Values\GameOptionValueForfeitAfterGeneric;
use MyDramGames\Core\GameOption\Values\GameOptionValueNumberOfPlayersGeneric;
use MyDramGames\Core\GamePlay\GamePlay;
use MyDramGames\Core\GamePlay\GamePlayStorableBase;
use MyDramGames\Core\GamePlay\Services\GamePlayServicesProvider;
use MyDramGames\Core\GamePlay\Storage\GamePlayStorage;
use MyDramGames\Core\GameRecord\GameRecord;
use MyDramGames\Core\GameRecord\GameRecordFactory;
use MyDramGames\Core\GameSetup\GameSetup;
use MyDramGames\Core\GameSetup\GameSetupBase;
use MyDramGames\Utils\Player\Player;
use PHPUnit\Framework\MockObject\Generator\Generator as MockGenerator;
use PHPUnit\Framework\MockObject\Generator\MockClass;
use PHPUnit\Framework\MockObject\MockBuilder;
use PHPUnit\Framework\MockObject\MockObject;

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
        return new class($optionsHandler, $valuesHandler) extends GameSetupBase implements GameSetup
        {
            protected function prepareDefaultOptions(GameOptionValueCollection $valuesHandler): array
            {
                return
                    [
                        new GameOptionNumberOfPlayersGeneric(
                            $valuesHandler->clone()->reset([
                                GameOptionValueNumberOfPlayersGeneric::Players002,
                                GameOptionValueNumberOfPlayersGeneric::Players003,
                            ]),
                            GameOptionValueNumberOfPlayersGeneric::Players002,
                            GameOptionTypeGeneric::Radio
                        ),

                        new GameOptionAutostartGeneric(
                            $valuesHandler->clone()->reset([
                                GameOptionValueAutostartGeneric::Enabled,
                                GameOptionValueAutostartGeneric::Disabled
                            ]),
                            GameOptionValueAutostartGeneric::Enabled,
                            GameOptionTypeGeneric::Checkbox
                        ),

                        new GameOptionForfeitAfterGeneric(
                            $valuesHandler->clone()->reset([
                                GameOptionValueForfeitAfterGeneric::Disabled,
                            ]),
                            GameOptionValueForfeitAfterGeneric::Disabled,
                            GameOptionTypeGeneric::Radio
                        ),

                    ];
            }
        };
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
        return new class($storage, $gamePlayServicesProvider) extends GamePlayStorableBase
        {
            protected array $words;
            protected const ?string GAME_MOVE_CLASS = MockObject::class;

            public function handleMove(GameMove $move): void
            {
                $this->validateGamePlayer($move->getPlayer());
                $this->validateNotFinished();
                $this->validateMove($move);

                $this->words[] = $move->getDetails()['word'];
                $this->saveData();
            }

            public function handleForfeit(Player $player): void
            {
                $this->validateNotFinished();
                $this->storage->setFinished();
            }

            public function getSituation(Player $player): array
            {
                $activePlayerName = $this->getActivePlayer()->getName();
                return [
                    'words' => $this->words,
                    'activePlayer' => $activePlayerName,
                    'yourId' => $this->getPlayerByName($player->getName())->getId(),
                ];
            }

            protected function initialize(): void
            {
                $this->words = [];
                $this->activePlayer = $this->getGameInvite()->getPlayers()->getOne(2);
            }

            protected function saveData(): void
            {
                $this->storage->setGameData([
                    'words' => $this->words,
                    'activePlayer' => $this->activePlayer,
                ]);
            }

            protected function loadData(): void
            {
                $data = $this->storage->getGameData();
                $this->words = $data['words'];
                $this->activePlayer = $data['activePlayer'];
            }

            protected function configureGamePlayServices(): void
            {

            }

            protected function runConfigurationAfterHooks(): void
            {

            }
        };
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
