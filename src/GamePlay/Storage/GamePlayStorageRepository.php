<?php

namespace MyDramGames\Core\GamePlay\Storage;

use MyDramGames\Core\GameInvite\GameInvite;

interface GamePlayStorageRepository
{
    public function getOne(int|string $id): GamePlayStorage;
    public function getOneByGameInvite(GameInvite $gameInvite): ?GamePlayStorage;
}
