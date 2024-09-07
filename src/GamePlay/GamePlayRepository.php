<?php

namespace MyDramGames\Core\GamePlay;

use MyDramGames\Core\GameInvite\GameInvite;

interface GamePlayRepository
{
    /**
     * @param int|string $gamePlayId
     * @return GamePlay
     */
    public function getOne(int|string $gamePlayId): GamePlay;

    /**
     * @param GameInvite $gameInvite
     * @return GamePlay|null
     */
    public function getOneByGameInvite(GameInvite $gameInvite): ?GamePlay;
}
