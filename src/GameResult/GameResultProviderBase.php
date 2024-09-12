<?php

namespace MyDramGames\Core\GameResult;

use MyDramGames\Core\GameRecord\GameRecordCollection;
use MyDramGames\Core\GameRecord\GameRecordFactory;

/**
 * Base class to make it easier to extend GameResultProvider interface having tools injected through constructor
 */
abstract class GameResultProviderBase implements GameResultProvider
{
    public function __construct(
        protected GameRecordFactory $gameRecordFactory,
        protected GameRecordCollection $gameRecordCollection,
    )
    {

    }
}
