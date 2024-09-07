<?php

namespace MyDramGames\Core\GamePlay\Storage;

use MyDramGames\Core\Exceptions\GamePlayStorageException;
use MyDramGames\Core\GameInvite\GameInvite;

interface GamePlayStorage
{
    /**
     * Should provide unique identifier of gameplay across whole application
     * @return int|string
     * @throws GamePlayStorageException
     */
    public function getId(): int|string;

    /**
     * Assigns single GameInvite
     * @param GameInvite $invite
     * @return void
     * @throws GamePlayStorageException
     */
    public function setGameInvite(GameInvite $invite): void;

    /**
     * @return GameInvite
     * @throws GamePlayStorageException
     */
    public function getGameInvite(): GameInvite;

    /**
     * Saves game data within a storage
     * @param array $data
     * @return void
     * @throws GamePlayStorageException
     */
    public function setGameData(array $data): void;

    /**
     * @return array
     * @throws GamePlayStorageException
     */
    public function getGameData(): array;

    /**
     * Set a flag that initial GamePlay setup was one
     * @return void
     * @throws GamePlayStorageException
     */
    public function setSetup(): void;

    /**
     * @return bool
     */
    public function getSetup(): bool;

    /**
     * Set a flag that gameplay has
     * @return void
     * @throws GamePlayStorageException
     */
    public function setFinished(): void;

    /**
     * @return bool
     */
    public function getFinished(): bool;
}
