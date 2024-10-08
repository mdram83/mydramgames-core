<?php

namespace MyDramGames\Core\GameBox;

use MyDramGames\Core\Exceptions\GameBoxException;
use MyDramGames\Core\GameSetup\GameSetup;

interface GameBox
{
    /**
     * Unique slug for the game
     * @return string
     * @throws GameBoxException in case value is missing
     */
    public function getSlug(): string;

    /**
     * User-friendly name of the game
     * @return string
     * @throws GameBoxException in case value is missing
     */
    public function getName(): string;

    /**
     * Description of game shown to user on game details screens
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * Descriptive number of players, could be 2-4, '2, 4, 6', depending on GameSetup
     * @return string
     * @throws GameBoxException in case this GameOption is set up (available values)
     */
    public function getNumberOfPlayersDescription(): string;

    /**
     * Expected duration of playing the game
     * @return int|null
     */
    public function getDurationInMinutes(): ?int;

    /**
     * Min age of player being able/allowed to play the game
     * @return int|null
     */
    public function getMinPlayerAge(): ?int;

    /**
     * Related GameSetup object
     * @return GameSetup
     * @throws GameBoxException in case GameOption is not set up
     */
    public function getGameSetup(): GameSetup;

    /**
     * Points to specific GamePlay interface implementation
     * @return string
     * @throws GameBoxException in case provided classname is not implementing GamePlay interface
     */
    public function getGamePlayClassname(): string;

    /**
     * Points to specific GameMoveFactory interface implementation
     * @return string
     * @throws GameBoxException in case provided classname is not implementing GameMove interface
     */
    public function getGameMoveFactoryClassname(): string;

    /**
     * Informs if gameplay can be initiated
     * @return bool
     */
    public function isActive(): bool;

    /**
     * Used to limit access to game for specific users
     * @return bool
     */
    public function isPremium(): bool;

    /**
     * @return array
     */
    public function toArray(): array;
}
