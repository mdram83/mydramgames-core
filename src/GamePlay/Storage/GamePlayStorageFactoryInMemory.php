<?php

namespace MyDramGames\Core\GamePlay\Storage;

use MyDramGames\Core\GameInvite\GameInvite;
use MyDramGames\Core\GamePlay\Storage\GamePlayStorageFactory;

class GamePlayStorageFactoryInMemory implements GamePlayStorageFactory
{
    /**
     * @inheritDoc
     */
    public function create(GameInvite $gameInvite): GamePlayStorage
    {
        return new GamePlayStorageInMemory($gameInvite);
    }
}
