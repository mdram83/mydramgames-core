<?php

namespace MyDramGames\Core\GameOption;

class GameOptionConfigurationGeneric implements GameOptionConfiguration
{
    public function __construct(protected string $optionKey, protected GameOptionValue $optionValue)
    {

    }

    /**
     * @inheritDoc
     */
    public function getGameOptionKey(): string
    {
        return $this->optionKey;
    }

    /**
     * @inheritDoc
     */
    public function getGameOptionValue(): GameOptionValue
    {
        return $this->optionValue;
    }
}