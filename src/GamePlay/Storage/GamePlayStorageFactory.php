<?php

namespace MyDramGames\Core\GamePlay\Storage;

use MyDramGames\Core\GameInvite\GameInvite;

interface GamePlayStorageFactory
{
    /**
     * Creates storage instance. Implementations of factory should differentiate storage type they create.
     * @param GameInvite $gameInvite
     * @return GamePlayStorage
     */
    public function create(GameInvite $gameInvite): GamePlayStorage;
}
