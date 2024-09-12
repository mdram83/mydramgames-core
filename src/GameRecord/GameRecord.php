<?php

namespace MyDramGames\Core\GameRecord;

use MyDramGames\Core\GameInvite\GameInvite;
use MyDramGames\Utils\Player\Player;

/**
 * GameRecord is saved result of finished game for each individual Player
 */
interface GameRecord
{
    /**
     * @return Player
     */
    public function getPlayer(): Player;

    /**
     * @return GameInvite
     */
    public function getGameInvite(): GameInvite;

    /**
     * Each specific game may implement different method of saving score, there may not be a standard between games.
     * @return array
     */
    public function getScore(): array;

    /**
     * @return bool
     */
    public function isWinner(): bool;
}
