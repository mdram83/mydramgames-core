<?php

namespace MyDramGames\Core\GamePlay;

use MyDramGames\Core\GameInvite\GameInvite;

interface GamePlayFactory
{
    /**
     * Should create a specific (provided by $gamePlayClassname) instance of GamePlay
     * @param string $gamePlayClassname
     * @param GameInvite $gameInvite
     * @return GamePlay
     */
    public function create(string $gamePlayClassname, GameInvite $gameInvite): GamePlay;
}
