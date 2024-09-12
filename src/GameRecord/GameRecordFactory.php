<?php

namespace MyDramGames\Core\GameRecord;

use MyDramGames\Core\GameInvite\GameInvite;
use MyDramGames\Utils\Player\Player;

interface GameRecordFactory
{
    /**
     * Creates a GameRecord. Specific implementations should consider storing the record in any persistent store.
     * @param GameInvite $invite
     * @param Player $player
     * @param bool $isWinner
     * @param array $score
     * @return GameRecord
     */
    public function create(GameInvite $invite, Player $player, bool $isWinner, array $score): GameRecord;
}
