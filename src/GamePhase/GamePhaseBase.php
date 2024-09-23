<?php

namespace MyDramGames\Core\GamePhase;

/**
 * Base class to make game specific extensions easier
 */
abstract class GamePhaseBase implements GamePhase
{
    /**
     * Adjust constant values for game specific implementations
     */
    public const string PHASE_KEY = '';
    protected const string PHASE_NAME = '';
    protected const string PHASE_DESCRIPTION = '';

    /**
     * @inheritDoc
     */
    final public function getKey(): string
    {
        return $this::PHASE_KEY;
    }

    /**
     * @inheritDoc
     */
    final public function getName(): string
    {
        return $this::PHASE_NAME;
    }

    /**
     * @inheritDoc
     */
    final public function getDescription(): string
    {
        return $this::PHASE_DESCRIPTION;
    }

    /**
     * @inheritDoc
     */
    abstract public function getNextPhase(bool $lastAttempt): GamePhase;
}
