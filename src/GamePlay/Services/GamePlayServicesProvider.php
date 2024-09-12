<?php

namespace MyDramGames\Core\GamePlay\Services;

use MyDramGames\Core\GameRecord\GameRecordCollection;
use MyDramGames\Core\GameRecord\GameRecordFactory;
use MyDramGames\Utils\Php\Collection\CollectionEngine;
use MyDramGames\Utils\Player\PlayerCollection;

/**
 *
 */
interface GamePlayServicesProvider
{
    /**
     * Should provide empty copy of CollectionEngine upon request
     * @return CollectionEngine
     */
    public function getCollectionEngine(): CollectionEngine;

    /**
     * Should provide empty copy of PlayerCollection
     * @return PlayerCollection
     */
    public function getPlayerCollection(): PlayerCollection;

    /**
     * Should provide Application specific implementation of GameRecordFactory
     * @return GameRecordFactory
     */
    public function getGameRecordFactory(): GameRecordFactory;

    /**
     * Should provide Application specific empty copy of GameRecordCollection
     * @return GameRecordCollection
     */
    public function getGameRecordCollection(): GameRecordCollection;
}
