<?php

namespace MyDramGames\Core\GameResult;

use MyDramGames\Core\GameRecord\GameRecord;

/**
 * Goal of per game implementations of this interface is to provide information about game result at the end of play.
 * It is not a goal of this class to report on historical games results. For such cases, @see GameRecord instead.
 */
interface GameResult
{
    /**
     * User-friendly message at the end of the game (e.g. who wins etc.)
     * @return string
     */
    public function getMessage(): string;

    /**
     * Any details that should be added to the message
     * @return array
     */
    public function getDetails(): array;

    /**
     * All information in array format that can be shared in e.g. json
     * @return array
     */
    public function toArray(): array;
}
