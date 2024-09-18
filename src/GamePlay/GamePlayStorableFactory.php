<?php

namespace MyDramGames\Core\GamePlay;

use MyDramGames\Core\GameInvite\GameInvite;
use MyDramGames\Core\GamePlay\Services\GamePlayServicesProvider;
use MyDramGames\Core\GamePlay\Storage\GamePlayStorageFactory;

class GamePlayStorableFactory implements GamePlayFactory
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
