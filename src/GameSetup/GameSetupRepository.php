<?php

namespace MyDramGames\Core\GameSetup;

use MyDramGames\Core\Exceptions\GameSetupException;

interface GameSetupRepository
{
    /**
     * Provides specific GameSetup record.
     * @param string $classname
     * @return GameSetup
     * @throws GameSetupException in case provided classname is not implementing GameSetup interface
     */
    public function getOneByClassname(string $classname): GameSetup;
}