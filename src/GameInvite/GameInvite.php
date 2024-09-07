<?php

namespace MyDramGames\Core\GameInvite;

use MyDramGames\Core\GameBox\GameBox;
use MyDramGames\Core\GameSetup\GameSetup;
use MyDramGames\Utils\Player\Player;
use MyDramGames\Utils\Player\PlayerCollection;

interface GameInvite
{
    /**
     * Provides unique id for game invite across whole application.
     * @return int|string
     */
    public function getId(): int|string;

    /**
     * @param Player $player
     * @param bool $host
     * @return void
     */
    public function addPlayer(Player $player, bool $host = false): void;

    /**
     * @return PlayerCollection
     */
    public function getPlayers(): PlayerCollection;

    /**
     * Informs if Player is added to list of game players
     * @param Player $player
     * @return bool
     */
    public function isPlayer(Player $player): bool;

    /**
     * @return Player
     */
    public function getHost(): Player;

    /**
     * Informs if Player was added as game host
     * @param Player $player
     * @return bool
     */
    public function isHost(Player $player): bool;

    /**
     * Shorthand method for getGameBox()->getGameSetup()
     * @return GameSetup
     */
    public function getGameSetup(): GameSetup;

    /**
     * @return GameBox
     */
    public function getGameBox(): GameBox;

    /**
     * @return array
     */
    public function toArray():array;
}
