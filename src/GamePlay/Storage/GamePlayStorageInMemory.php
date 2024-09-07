<?php

namespace MyDramGames\Core\GamePlay\Storage;

use MyDramGames\Core\Exceptions\GamePlayStorageException;
use MyDramGames\Core\GameInvite\GameInvite;

/**
 * Example implementation of GamePlayStorage.
 * This example has limited use for testing and presentation purpose.
 * Each application should implement specific GamePlayStorage method, using database or other persistent layer.
 */
class GamePlayStorageInMemory implements GamePlayStorage
{
    protected array $gameData;
    protected bool $setup = false;
    protected bool $isFinished = false;

    public function __construct(protected GameInvite $gameInvite)
    {

    }

    /**
     * @inheritDoc
     */
    public function getId(): int|string
    {
        return 1;
    }

    /**
     * @inheritDoc
     */
    public function setGameInvite(GameInvite $invite): void
    {
        throw new GamePlayStorageException(GamePlayStorageException::MESSAGE_INVALID_INVITE);
    }

    /**
     * @inheritDoc
     */
    public function getGameInvite(): GameInvite
    {
        return $this->gameInvite;
    }

    /**
     * @inheritDoc
     */
    public function setGameData(array $data): void
    {
        $this->validateFinished();
        $this->gameData = $data;
    }

    /**
     * @inheritDoc
     */
    public function getGameData(): array
    {
        return $this->gameData;
    }

    /**
     * @inheritDoc
     */
    public function setSetup(): void
    {
        if ($this->getSetup()) {
            throw new GamePlayStorageException(GamePlayStorageException::MESSAGE_SETUP_ALREADY_SET);
        }
        $this->setup = true;
    }

    /**
     * @inheritDoc
     */
    public function getSetup(): bool
    {
        return $this->setup;
    }

    /**
     * @inheritDoc
     */
    public function setFinished(): void
    {
        $this->validateFinished();
        $this->isFinished = true;
    }

    /**
     * @inheritDoc
     */
    public function getFinished(): bool
    {
        return $this->isFinished;
    }

    /**
     * @return void
     * @throws GamePlayStorageException
     */
    public function validateFinished(): void
    {
        if ($this->getFinished()) {
            throw new GamePlayStorageException(GamePlayStorageException::MESSAGE_FINISH_ALREADY_SET);
        }
    }
}