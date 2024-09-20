<?php

namespace MyDramGames\Core\GameSetup;

use MyDramGames\Core\Exceptions\GameSetupException;
use MyDramGames\Core\GameOption\GameOptionCollection;
use MyDramGames\Core\GameOption\GameOptionValueCollection;
use MyDramGames\Utils\Exceptions\CollectionException;

class GameSetupBaseRepository implements GameSetupRepository
{
    public function __construct(
        protected readonly GameOptionCollection $optionsHandler,
        protected readonly GameOptionValueCollection $valuesHandler
    )
    {

    }

    /**
     * @inheritDoc
     * @throws CollectionException
     */
    public function getOneByClassname(string $classname): GameSetup
    {
        $this->validateClassnameImplementsInterface($classname, GameSetup::class);
        return new $classname($this->optionsHandler->clone()->reset(), $this->valuesHandler->clone()->reset());
    }

    /**
     * @throws GameSetupException
     */
    protected function validateClassnameImplementsInterface(string $class, string $interface): void
    {
        if (!class_exists($class) || !in_array($interface, class_implements($class))) {
            throw new GameSetupException(GameSetupException::MESSAGE_NO_ABS_FACTORY);
        }
    }
}
