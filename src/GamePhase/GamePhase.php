<?php

namespace MyDramGames\Core\GamePhase;

/**
 * GamePhase is an optional element that could be utilized in specific GamePlay implementation.
 * It may help to handle user actions differently depending on current phase of the game.
 */
interface GamePhase
{
    /**
     * Should provide unique key of phase across specific GamePlay implementation
     * @return string
     */
    public function getKey(): string;

    /**
     * Should provide user-friendly name of the phase
     * @return string
     */
    public function getName(): string;

    /**
     * Should provide user-friendly description holding e.g. tips on next actions
     * @return string
     */
    public function getDescription(): string;

    /**
     * Should inform about next possible GamePhase, with condition if this is last phase attempt or not.
     * @param bool $lastAttempt
     * @return GamePhase
     */
    public function getNextPhase(bool $lastAttempt): GamePhase;
}
