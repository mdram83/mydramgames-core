<?php

namespace MyDramGames\Core\GamePlay;

use MyDramGames\Core\GameInvite\GameInvite;

interface GamePlayFactory
{
    /**
     * Should create a specific instance of GamePlay
     * @param GameInvite $gameInvite
     * @return GamePlay
     */
    public function create(GameInvite $gameInvite): GamePlay;
}
