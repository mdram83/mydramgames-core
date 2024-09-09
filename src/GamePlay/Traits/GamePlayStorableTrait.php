<?php

namespace MyDramGames\Core\GamePlay\Traits;

use MyDramGames\Core\Exceptions\GameOptionException;
use MyDramGames\Core\Exceptions\GamePlayException;
use MyDramGames\Core\Exceptions\GamePlayStorageException;
use MyDramGames\Core\GameInvite\GameInvite;
use MyDramGames\Utils\Player\PlayerCollection;

trait GamePlayStorableTrait
{
    /**
     * @inheritDoc
     * @throws GamePlayException
     */
    final public function getId(): int|string
    {
        try {

            return $this->storage->getId();

        } catch (GamePlayStorageException $e) {
            throw new GamePlayException(GamePlayException::MESSAGE_STORAGE_INCORRECT);
        }
    }

    /**
     * @inheritDoc
     * @throws GamePlayException
     */
    final public function getPlayers(): PlayerCollection
    {
        try {

            return $this->storage->getGameInvite()->getPlayers();

        } catch (GamePlayStorageException $e) {
            throw new GamePlayException(GamePlayException::MESSAGE_STORAGE_INCORRECT);
        }
    }

    /**
     * @inheritDoc
     * @throws GamePlayException
     */
    final public function getGameInvite(): GameInvite
    {
        try {

            return $this->storage->getGameInvite();

        } catch (GamePlayStorageException $e) {
            throw new GamePlayException(GamePlayException::MESSAGE_STORAGE_INCORRECT);
        }
    }

    /**
     * @inheritDoc
     */
    final public function isFinished(): bool
    {
        return $this->storage->getFinished();
    }

    /**
     * @return void
     * @throws GamePlayException
     */
    final protected function setUpStorage(): void
    {
        try {
            if (!$this->storage->getSetup()) {
                $this->initialize();
                $this->saveData();
                $this->storage->setSetup();
            } else {
                $this->loadData();
            }
        } catch (GamePlayStorageException) {
            throw new GamePlayException(GamePlayException::MESSAGE_STORAGE_INCORRECT);
        }
    }

    /**
     * @throws GamePlayException
     */
    final protected function validateStorage(): void
    {
        try {
            $gameInvite = $this->storage->getGameInvite();

            if (
                $gameInvite->getGameSetup()->getNumberOfPlayers()->getConfiguredValue()->getValue()
                !== $gameInvite->getPlayers()->count()
            ) {
                throw new GamePlayException(GamePlayException::MESSAGE_MISSING_PLAYERS);
            }

        } catch (GamePlayStorageException|GameOptionException) {
            throw new GamePlayException(GamePlayException::MESSAGE_STORAGE_INCORRECT);
        }
    }
}
