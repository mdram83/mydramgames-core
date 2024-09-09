<?php

namespace MyDramGames\Core\GamePlay;

use MyDramGames\Core\Exceptions\GamePlayException;
use MyDramGames\Core\GameMove\GameMove;
use MyDramGames\Core\GamePlay\Services\GamePlayServicesProvider;
use MyDramGames\Core\GamePlay\Storage\GamePlayStorage;
use MyDramGames\Core\GamePlay\Traits\GamePlayGetPlayerByNameTrait;
use MyDramGames\Core\GamePlay\Traits\GamePlayStorableTrait;
use MyDramGames\Core\GamePlay\Traits\GamePlayValidationTrait;
use MyDramGames\Core\GamePlay\Traits\GetActivePlayerPropertyTrait;
use MyDramGames\Utils\Player\Player;

/**
 * This is base implementation of GamePlay interface.
 * This implementation is utilizing GamePlayStorage interface to read/write information about game status or progress.
 * You can extend this class to define specific behavior of your game.
 * This is about handling moves, initializing game, save/load logic, utilizing services etc.
 * You have a lot of flexibility in how you modify those elements to adjust to your desired game.
 */
abstract class GamePlayStorableBase implements GamePlay
{
    use GamePlayStorableTrait;
    use GetActivePlayerPropertyTrait;
    use GamePlayGetPlayerByNameTrait;
    use GamePlayValidationTrait;

    /**
     * This constant point to name of GameMove game specific implementation.
     */
    protected const ?string GAME_MOVE_CLASS = null;

    /**
     * @throws GamePlayException
     */
    final public function __construct(
        protected GamePlayStorage $storage,
        protected GamePlayServicesProvider $gamePlayServicesProvider,
    )
    {
        $this->validateStorage();
        $this->configureGamePlayServices();
        $this->setUpInStorage();
        $this->runConfigurationAfterHooks();
    }

    /**
     * Here all the game magic happen.
     * Overwrite this method with game specific move handling logic.
     * Typically, you will utilize different GameMove or GamePhase implementations.
     * More complex logic may also require additional service providers being able to handle specific moves.
     * @inheritDoc
     */
    abstract public function handleMove(GameMove $move): void;

    /**
     * And here all the game magic is usually already gone.
     * Overwrite this method with game specific forfeit logic.
     * You may want to stop the gameplay or play with remaining users only. Any way you see it is good way.
     * @inheritDoc
     */
    abstract public function handleForfeit(Player $player): void;

    /**
     * Overwrite this method with whatever information you must show to specific user.
     * Consider what information should be visible and what not (e.g. not to see other players items in some games).
     * Typically, there is some external (at Application level) event handler responsible for running this method.
     * @inheritDoc
     */
    abstract public function getSituation(Player $player): array;

    /**
     * This method should initialize specific game to the state when players can make first actions.
     * Imagine it as taking board, decks, dices etc. out of the box and putting on the table in proper stocks etc.
     * Typically, initial setup involving players (like draw the character) should not be included.
     * @return void
     */
    abstract protected function initialize(): void;

    /**
     * This method should save necessary data (e.g. calling storage->setGameData()).
     * It is automatically called once in constructor, after initialize() method has run)
     * Typically, you will use loadData() method later to load the data saved by saveData() method.
     * @return void
     */
    abstract protected function saveData(): void;

    /**
     * @See saveData
     * @return void
     */
    abstract protected function loadData(): void;

    /**
     * Performs necessary class instance configuration to be used further in initialization or handling moves etc.
     * @return void
     */
    abstract protected function configureGamePlayServices(): void;

    /**
     * This method should be used to run any after-hooks if needed
     * @return void
     */
    abstract protected function runConfigurationAfterHooks(): void;
}
