<?php

namespace MyDramGames\Core\GameFactory;

use MyDramGames\Core\GameInvite\GameInvite;
use MyDramGames\Core\GameOption\GameOptionCollection;
use MyDramGames\Core\GameOption\GameOptionValueCollection;
use MyDramGames\Core\GamePlay\GamePlay;
use MyDramGames\Core\GamePlay\Services\GamePlayServicesProvider;
use MyDramGames\Core\GamePlay\Storage\GamePlayStorageFactory;
use MyDramGames\Core\GameSetup\GameSetup;
use MyDramGames\Utils\Exceptions\CollectionException;

class GameFactoryStorable implements GameFactory
{
    public function __construct(
        protected GameOptionCollection $gameOptionCollection,
        protected GameOptionValueCollection $gameOptionValueCollection,
        protected GamePlayStorageFactory $gamePlayStorageFactory,
        protected GamePlayServicesProvider $gamePlayServicesProvider,
    )
    {

    }

    /**
     * @inheritDoc
     * @throws CollectionException
     */
    public function createGameSetup(string $gameSetupClassname): GameSetup
    {
        return new $gameSetupClassname(
            $this->gameOptionCollection->clone()->reset(),
            $this->gameOptionValueCollection->clone()->reset(),
        );
    }

    /**
     * @inheritDoc
     */
    public function createGamePlay(string $gamePlayClassname, GameInvite $gameInvite): GamePlay
    {
        $storage = $this->gamePlayStorageFactory->create($gameInvite);
        return new $gamePlayClassname($storage, $this->gamePlayServicesProvider);
    }
}
