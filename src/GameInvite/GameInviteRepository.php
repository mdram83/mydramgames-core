<?php

namespace MyDramGames\Core\GameInvite;

interface GameInviteRepository
{
    public function getOne(string|int $gameId): GameInvite;
}
