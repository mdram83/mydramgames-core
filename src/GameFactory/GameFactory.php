<?php

namespace MyDramGames\Core\GameFactory;

use MyDramGames\Core\GameInvite\GameInvite;
use MyDramGames\Core\GamePlay\GamePlay;
use MyDramGames\Core\GameSetup\GameSetup;

interface GameFactory
{
    /**
     * Should create a specific (provided by $gameSetupClassname) instance of GameSetup
     * @param string $gameSetupClassname
     * @return GameSetup
     */
    public function createGameSetup(string $gameSetupClassname): GameSetup;

    /**
     * Should create a specific (provided by $gamePlayClassname) instance of GamePlay
     * @param string $gamePlayClassname
     * @param GameInvite $gameInvite
     * @return GamePlay
     */
    public function createGamePlay(string $gamePlayClassname, GameInvite $gameInvite): GamePlay;
}
