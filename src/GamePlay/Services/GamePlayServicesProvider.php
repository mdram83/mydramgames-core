<?php

namespace MyDramGames\Core\GamePlay\Services;

use MyDramGames\Utils\Php\Collection\CollectionEngine;
use MyDramGames\Utils\Player\PlayerCollection;

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
}
