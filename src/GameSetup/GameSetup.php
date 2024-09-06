<?php

namespace MyDramGames\Core\GameSetup;

use MyDramGames\Core\GameOption\GameOption;
use MyDramGames\Core\GameOption\GameOptionCollection;
use MyDramGames\Core\GameOption\GameOptionConfigurationCollection;

interface GameSetup
{
    /**
     * @param string $key
     * @return GameOption
     */
    public function getOption(string $key): GameOption;

    /**
     * @return GameOptionCollection
     */
    public function getAllOptions(): GameOptionCollection;

    /**
     * Configure Game Options to specific value provided within collection of GameOptionConfiguration
     * @param GameOptionConfigurationCollection $configurations
     * @return void
     */
    public function configureOptions(GameOptionConfigurationCollection $configurations): void;

    /**
     * Informs if all options are configured
     * @return bool
     */
    public function isConfigured(): bool;

    /**
     * Should inform if options are added including their default and available values
     * @return bool
     */
    public function isSetUp(): bool;

    /**
     * Shorthand function for method call getOption('numberOfPlayers')
     * @return GameOption
     */
    public function getNumberOfPlayers(): GameOption;

    /**
     * Shorthand function for method call getOption('autostart')
     * @return GameOption
     */
    public function getAutostart(): GameOption;
}
