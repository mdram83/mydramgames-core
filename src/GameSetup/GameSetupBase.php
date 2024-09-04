<?php

namespace MyDramGames\Core\GameSetup;

use MyDramGames\Core\Exceptions\GameOptionException;
use MyDramGames\Core\Exceptions\GameSetupException;
use MyDramGames\Core\GameOption\GameOption;
use MyDramGames\Core\GameOption\GameOptionCollection;
use MyDramGames\Core\GameOption\GameOptionConfigurationCollection;
use MyDramGames\Core\GameOption\GameOptionTypeGeneric;
use MyDramGames\Core\GameOption\GameOptionValue;
use MyDramGames\Core\GameOption\GameOptionValueCollection;
use MyDramGames\Core\GameOption\Options\GameOptionAutostartGeneric;
use MyDramGames\Core\GameOption\Options\GameOptionForfeitAfterGeneric;
use MyDramGames\Core\GameOption\Options\GameOptionNumberOfPlayersGeneric;
use MyDramGames\Core\GameOption\Values\GameOptionValueAutostartGeneric;
use MyDramGames\Core\GameOption\Values\GameOptionValueForfeitAfterGeneric;
use MyDramGames\Core\GameOption\Values\GameOptionValueNumberOfPlayersGeneric;
use MyDramGames\Utils\Exceptions\CollectionException;

abstract class GameSetupBase implements GameSetup
{
    protected GameOptionCollection $options;

    /**
     * @throws GameOptionException
     * @throws CollectionException
     */
    final public function __construct(GameOptionCollection $optionsHandler, GameOptionValueCollection $valuesHandler)
    {
        $this->options = $optionsHandler->reset($this->prepareDefaultOptions($valuesHandler->reset()));
    }

    /**
     * This is only method that must be overwritten in specific per game implementations extending GameSetupBase.
     * In this method, you should add each GameOption with their available values, default value and type.
     * Consider that 'numberOfPlayers', 'autostart' and 'forfeitAfter' are mandatory. Each must be added to `options`.
     * @throws GameOptionException
     * @throws CollectionException
     */
    protected function prepareDefaultOptions(GameOptionValueCollection $valuesHandler): array
    {
        return
            [
                new GameOptionNumberOfPlayersGeneric(
                    $valuesHandler->clone()->reset([
                        GameOptionValueNumberOfPlayersGeneric::Players002,
                    ]),
                    GameOptionValueNumberOfPlayersGeneric::Players002,
                    GameOptionTypeGeneric::Radio
                ),

                new GameOptionAutostartGeneric(
                    $valuesHandler->clone()->reset([
                        GameOptionValueAutostartGeneric::Enabled,
                        GameOptionValueAutostartGeneric::Disabled
                    ]),
                    GameOptionValueAutostartGeneric::Enabled,
                    GameOptionTypeGeneric::Checkbox
                ),

                new GameOptionForfeitAfterGeneric(
                    $valuesHandler->clone()->reset([
                        GameOptionValueForfeitAfterGeneric::Disabled,
                    ]),
                    GameOptionValueForfeitAfterGeneric::Disabled,
                    GameOptionTypeGeneric::Radio
                ),

            ];
    }

    /**
     * @throws GameSetupException
     * @throws CollectionException
     */
    final public function getOption(string $key): GameOption
    {
        if (!$this->options->exist($key)) {
            throw new GameSetupException(GameSetupException::MESSAGE_OPTION_NOT_SET);
        }

        return $this->options->getOne($key);
    }

    final public function getAllOptions(): GameOptionCollection
    {
        return $this->options;
    }

    /**
     * @throws GameSetupException
     * @throws CollectionException
     */
    final public function configureOptions(GameOptionConfigurationCollection $configurations): void
    {
        $this->validateOptions($configurations);

        foreach ($configurations->toArray() as $configuration) {
            $this
                ->getOption($configuration->getGameOptionKey())
                ->setConfiguredValue($configuration->getGameOptionValue());
        }
    }

    /**
     * @throws CollectionException
     */
    final public function isConfigured(): bool
    {
        return $this->options->count() === $this->options->filter(fn($option) => $option->isConfigured())->count();
    }

    /**
     * @throws GameSetupException
     * @throws CollectionException
     */
    final public function getNumberOfPlayers(): GameOption
    {
        return $this->getOption('numberOfPlayers');
    }

    /**
     * @throws GameSetupException
     * @throws CollectionException
     */

    final public function getAutostart(): GameOption
    {
        return $this->getOption('autostart');
    }

    /**
     * @throws GameSetupException
     * @throws CollectionException
     */
    final protected function validateOptions(GameOptionConfigurationCollection $configurations): void
    {
        foreach ($configurations->toArray() as $configuration) {
            if ($this->isExceedingDefaults($configuration->getGameOptionKey(), $configuration->getGameOptionValue())) {
                throw new GameSetupException(GameSetupException::MESSAGE_OPTION_OUTSIDE);
            }
        }

        if (!$this->isCoveringDefaults($configurations)) {
            throw new GameSetupException(GameSetupException::MESSAGE_OPTION_NOT_SET);
        }
    }

    /**
     * @throws CollectionException
     */
    final protected function isExceedingDefaults(string $key, GameOptionValue $value): bool
    {
//        echo PHP_EOL;
//        var_dump($key);
//        echo PHP_EOL;

        if (!$this->options->exist($key)) {
            return true;
        }

        if (!in_array($value, $this->options->getOne($key)->getAvailableValues()->toArray(), true)) {
//            echo PHP_EOL . "Value " . $value->getValue() . " of key $key not in available values" . PHP_EOL;
            return true;
        }

        return false;
    }

    final protected function isCoveringDefaults(GameOptionConfigurationCollection $configurations): bool
    {
        foreach($this->options->keys() as $key) {
            if (!$configurations->exist($key)) {
                return false;
            }
        }

        return true;
    }
}
