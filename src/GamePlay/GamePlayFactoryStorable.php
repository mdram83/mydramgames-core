<?php

namespace MyDramGames\Core\GamePlay;

use MyDramGames\Core\Exceptions\GameBoxException;
use MyDramGames\Core\GameInvite\GameInvite;
use MyDramGames\Core\GamePlay\Services\GamePlayServicesProvider;
use MyDramGames\Core\GamePlay\Storage\GamePlayStorageFactory;

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
     * @throws GameBoxException
     */
    public function create(GameInvite $gameInvite): GamePlay
    {
        $storage = $this->gamePlayStorageFactory->create($gameInvite);
        $gamePlayClassname = $gameInvite->getGameBox()->getGamePlayClassname();

        return new $gamePlayClassname($storage, $this->gamePlayServicesProvider);
    }
}
