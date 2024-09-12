<?php

namespace MyDramGames\Core\GameResult;

use MyDramGames\Core\GameRecord\GameRecordFactory;

/**
 * Base class to make it easier to extend GameResultProvider interface having necessary factory injected through constructor
 */
abstract class GameResultProviderWithFactoryBase implements GameResultProvider
{
    public function __construct(protected GameRecordFactory $gameRecordFactory)
    {

    }
}
