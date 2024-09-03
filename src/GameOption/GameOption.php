<?php

namespace MyDramGames\Core\GameOption;

use MyDramGames\Core\Exceptions\GameOptionException;

interface GameOption
{
    /**
     * Provides a unique string key for specific GameOption implementation
     * @return string
     */
    public function getKey(): string;

    /**
     * Provides a user-friendly short name of specific GameOption implementation
     * @return string
     */
    public function getName(): string;

    /**
     * Provides more detailed description of GameOption, e.g. what it means, how impact the game etc.
     * @return string
     */
    public function getDescription(): string;

    /**
     * Provides type of GameOption for handling value selection (e.g. select, checkbox etc.)
     * @return GameOptionType
     */
    public function getType(): GameOptionType;

    /**
     * Provides default value for specific GameOption implementation
     * @return GameOptionValue
     */
    public function getDefaultValue(): GameOptionValue;

    /**
     * Provides collection of all available option values for specific GameOption implementation
     * @return GameOptionValueCollection
     */
    public function getAvailableValues(): GameOptionValueCollection;

    /**
     * Allow to set specific value for the option
     * @param GameOptionValue $value
     * @return void
     */
    public function setConfiguredValue(GameOptionValue $value): void;

    /**
     * Provides information about specific value configured for the option if available
     * @return GameOptionValue
     * @throws GameOptionException
     */
    public function getConfiguredValue(): GameOptionValue;

    /**
     * Informs if value was already set for the option
     * @return bool
     */
    public function isConfigured(): bool;
}
