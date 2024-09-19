<?php

namespace MyDramGames\Core\GamePlay;

use MyDramGames\Core\GameInvite\GameInvite;
use MyDramGames\Core\GameOption\GameOptionCollection;
use MyDramGames\Core\GameOption\GameOptionValueCollection;
use MyDramGames\Core\GamePlay\Services\GamePlayServicesProvider;
use MyDramGames\Core\GamePlay\Storage\GamePlayStorageFactory;
use MyDramGames\Core\GameSetup\GameSetup;
use MyDramGames\Utils\Exceptions\CollectionException;

class GamePlayFactoryStorable implements GamePlayFactory
{
    public function __construct(
        protected GamePlayStorageFactory $gamePlayStorageFactory,
        protected GamePlayServicesProvider $gamePlayServicesProvider,
    )
    {

    }

    /**
     * @inheritDoc
     */
    public function create(string $gamePlayClassname, GameInvite $gameInvite): GamePlay
    {
        $storage = $this->gamePlayStorageFactory->create($gameInvite);
        return new $gamePlayClassname($storage, $this->gamePlayServicesProvider);
    }
}
