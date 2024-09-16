<?php

namespace MyDramGames\Core\GameMove;

use MyDramGames\Utils\Player\Player;

interface GameMoveFactory
{
    /**
     * Optional implementations per game should implement method to create game specific GameMove instance.
     * May be required for specific and more than minimal validations and be utilized in GameIndex implementations.
     * @param Player $player
     * @param array $inputs
     * @return GameMove
     */
    public function create(Player $player, array $inputs): GameMove;
}
