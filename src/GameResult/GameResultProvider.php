<?php

namespace MyDramGames\Core\GameResult;

use MyDramGames\Core\Exceptions\GameResultProviderException;
use MyDramGames\Core\GameInvite\GameInvite;
use MyDramGames\Core\GameRecord\GameRecordCollection;

/**
 * Goal of this class implementations (per game) should be to recognize winning condition and provide results.
 * In addition, be able to create and store GameRecord instances.
 */
interface GameResultProvider
{
    /**
     * Provided with specific per game input it calculate win/draw and provide a result or null should the game continue
     * @param mixed $data
     * @return GameResult|null
     * @throws GameResultProviderException
     */
    public function getResult(mixed $data): ?GameResult;

    /**
     * Creates, stores and returns GameRecordCollection in case result is provided. Throws exception otherwise.
     * @param GameInvite $gameInvite
     * @return GameRecordCollection
     * @throws GameResultProviderException
     */
    public function createGameRecords(GameInvite $gameInvite): GameRecordCollection;
}
