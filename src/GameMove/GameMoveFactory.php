<?php

namespace MyDramGames\Core\GameMove;

use MyDramGames\Utils\Player\Player;

interface GameMoveFactory
{
    /**
     * Per game implementations should implement method to create game specific GameMove instance.
     * This can be done by either method in GameMove[SpecificGame] class or as dedicated factory class.
     * @param Player $player
     * @param array $inputs
     * @return GameMove
     */
    public static function create(Player $player, array $inputs): GameMove;
}
