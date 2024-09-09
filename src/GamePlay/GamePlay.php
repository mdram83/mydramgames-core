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
     * Critical method that should be defined to handle each specific to game player action/move.
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
     * Critical method that should be defined to communicate current game situation to specific Player.
     * @param Player $player
     * @return array
     */
    public function getSituation(Player $player): array;

    /**
     * @return bool
     */
    public function isFinished(): bool;
}
