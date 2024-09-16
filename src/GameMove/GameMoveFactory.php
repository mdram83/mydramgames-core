<?php

namespace MyDramGames\Core\GameMove;

use MyDramGames\Utils\Player\Player;

interface GameMoveFactory
{
    public function create(Player $player, array $inputs): GameMove;
}
