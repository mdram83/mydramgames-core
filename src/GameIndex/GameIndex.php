<?php

namespace MyDramGames\Core\GameIndex;

use MyDramGames\Core\GameBox\GameBox;
use MyDramGames\Core\GameInvite\GameInvite;
use MyDramGames\Core\GameMove\GameMove;
use MyDramGames\Core\GamePlay\GamePlay;
use MyDramGames\Core\GameSetup\GameSetup;
use MyDramGames\Utils\Player\Player;

/**
 * Abstract Factory to create set of objects related to specific game (like tic-tac-toe).
 * Each game should implement its own representation
 */
interface GameIndex
{
    /**
     * Provide unique across whole application slug of the game
     * @return string
     */
    public function getSlug(): string;

    /**
     * Allows to overwrite GameBox specific parameters in case platform setup is different
     * @param bool $isActiveOverwrite
     * @param bool $isPremiumOverwrite
     * @return GameBox
     */
    public function getGameBox(?bool $isActiveOverwrite = null, ?bool $isPremiumOverwrite = null): GameBox;

    /**
     * @return GameSetup
     */
    public function getGameSetup(): GameSetup;

    /**
     * Abstract Factory method to create game specific move instance
     * @param Player $player
     * @param array $inputs
     * @return GameMove
     */
    public function createGameMove(Player $player, array $inputs): GameMove;

    /**
     * Should provide fully qualified name of specific GamePlay class
     * @return string
     */
    public function getGamePlayClassname(): string;
}
