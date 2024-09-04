<?php

namespace MyDramGames\Core\GameOption;

use MyDramGames\Core\Exceptions\GameOptionException;

/**
 * This class can be extended to easily setup new GameOption specific instances.
 * Minimal implementation requires setting up OPTION_KEY, OPTION_NAME, OPTION_DESCRIPTION and VALUE_CLASS values.
 * Optional setup may be overwriting params and return types on properties of class and constructor.
 */
abstract class GameOptionBase implements GameOption
{
    protected GameOptionValue $configuredValue;

    protected const ?string OPTION_KEY = null;
    protected const ?string OPTION_NAME = null;
    protected const ?string OPTION_DESCRIPTION = null;
    protected const ?string VALUE_CLASS = null;

    /**
     * @throws GameOptionException
     */
    public function __construct(
        protected GameOptionValueCollection $availableValues,
        protected GameOptionValue $defaultValue,
        protected GameOptionType $type,
    )
    {
        $this->validateOptionValueCollection($availableValues);
        $this->validateOptionValue($defaultValue);
    }

    final public function getKey(): string
    {
        return $this::OPTION_KEY;
    }

    final public function getName(): string
    {
        return $this::OPTION_NAME;
    }

    final public function getDescription(): string
    {
        return $this::OPTION_DESCRIPTION;
    }

    final public function getType(): GameOptionType
    {
        return $this->type;
    }

    final public function getDefaultValue(): GameOptionValue
    {
        return $this->defaultValue;
    }

    final public function getAvailableValues(): GameOptionValueCollection
    {
        return $this->availableValues;
    }

    final public function getConfiguredValue(): GameOptionValue
    {
        if (!isset($this->configuredValue)) {
            throw new GameOptionException(GameOptionException::MESSAGE_NOT_CONFIGURED);
        }
        return $this->configuredValue;
    }

    /**
     * @throws GameOptionException
     */
    final public function setConfiguredValue(GameOptionValue $value): void
    {
        if (isset($this->configuredValue)) {
            throw new GameOptionException(GameOptionException::MESSAGE_ALREADY_CONFIGURED);
        }
        $this->configuredValue = $value;
    }

    final public function isConfigured(): bool
    {
        return isset($this->configuredValue);
    }

    /**
     * @throws GameOptionException
     */
    final protected function validateOptionValueCollection(GameOptionValueCollection $values): void
    {
        if ($values->isEmpty()) {
            throw new GameOptionException(GameOptionException::MESSAGE_MISSING_VALUE);
        }

        foreach ($values->toArray() as $value) {
            $this->validateOptionValue($value);
        }
    }

    /**
     * @throws GameOptionException
     */
    final protected function validateOptionValue(GameOptionValue $optionValue): void
    {
        if (!is_a($optionValue, static::VALUE_CLASS)) {
            throw new GameOptionException(GameOptionException::MESSAGE_INCOMPATIBLE_VALUE);
        }
    }
}
