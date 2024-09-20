<?php

namespace MyDramGames\Core\GameRecord;

use MyDramGames\Core\GameInvite\GameInvite;

interface GameRecordRepository
{
    /**
     * Provides collection of game records for specific GameInvite instance
     * @param GameInvite $gameInvite
     * @return GameRecordCollection
     */
    public function getByGameInvite(GameInvite $gameInvite): GameRecordCollection;
}
