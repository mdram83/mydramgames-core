<?php

namespace MyDramGames\Core\GamePlay\Services;

use MyDramGames\Core\GameRecord\GameRecordCollection;
use MyDramGames\Core\GameRecord\GameRecordFactory;
use MyDramGames\Utils\Exceptions\CollectionException;
use MyDramGames\Utils\Php\Collection\CollectionEngine;
use MyDramGames\Utils\Player\PlayerCollection;

readonly class GamePlayServicesProviderGeneric implements GamePlayServicesProvider
{
    public function __construct(
        protected CollectionEngine $collectionEngine,
        protected PlayerCollection $playerCollection,
        protected GameRecordFactory $gameRecordFactory,
        protected GameRecordCollection $gameRecordCollection,
    )
    {

    }

    /**
     * @inheritDoc
     * @throws CollectionException
     */
    public function getCollectionEngine(): CollectionEngine
    {
        return $this->collectionEngine->clone()->reset();
    }

    /**
     * @inheritDoc
     */
    public function getPlayerCollection(): PlayerCollection
    {
        return $this->playerCollection->clone()->reset();
    }

    /**
     * @inheritDoc
     */
    public function getGameRecordFactory(): GameRecordFactory
    {
        return $this->gameRecordFactory;
    }

    /**
     * @inheritDoc
     */
    public function getGameRecordCollection(): GameRecordCollection
    {
        return $this->gameRecordCollection->clone()->reset();
    }
}
