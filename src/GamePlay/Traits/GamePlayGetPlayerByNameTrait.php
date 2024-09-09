<?php

namespace MyDramGames\Core\GamePlay\Traits;

use MyDramGames\Core\Exceptions\GamePlayException;
use MyDramGames\Utils\Exceptions\CollectionException;
use MyDramGames\Utils\Player\Player;

trait GamePlayGetPlayerByNameTrait
{
    /**
     * @param string|null $playerName
     * @return Player|null
     * @throws GamePlayException
     */
    final protected function getPlayerByName(?string $playerName): ?Player
    {
        try {
            return $this
                ->getPlayers()
                ->filter(fn($player) => $player->getName() === $playerName)
                ->pullFirst();

        } catch (CollectionException) {
            return null;
        }
    }
}
