<?php

namespace MyDramGames\Core\GamePlay;

use MyDramGames\Core\GameInvite\GameInvite;
use MyDramGames\Core\GameMove\GameMove;
use MyDramGames\Utils\Player\Player;
use MyDramGames\Utils\Player\PlayerCollection;

/**
 * This is main class responsible for handling different specific games like 'TicTacToe' or 'Thousand' or else.
 */
interface GamePlay
{
    /**
     * Unique id across the application, allowing to recognize specific gameplay
     * @return int|string
     */
    public function getId(): int|string;

    /**
     * @return PlayerCollection
     */
    public function getPlayers(): PlayerCollection;

    /**
     * Informs who's turn is at this moment
     * @return Player|null
     */
    public function getActivePlayer(): ?Player;

    /**
     * Reference to GameInvite
     * @return GameInvite
     */
    public function getGameInvite(): GameInvite;

    /**
     * Key method that has to be handled specifically for the game
     * @param GameMove $move
     * @return void
     */
    public function handleMove(GameMove $move): void;

    /**
     * Handle forfeit of one of gameplay participants
     * @param Player $player
     * @return void
     */
    public function handleForfeit(Player $player): void;

    /**
     * Key method that should be used for sharing current game situation with an individual Player
     * @param Player $player
     * @return array
     */
    public function getSituation(Player $player): array;

    /**
     * @return bool
     */
    public function isFinished(): bool;
}
