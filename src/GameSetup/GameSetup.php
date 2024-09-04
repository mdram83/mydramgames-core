<?php

namespace MyDramGames\Core\GameSetup;

use MyDramGames\Core\GameOption\GameOption;
use MyDramGames\Core\GameOption\GameOptionCollection;
use MyDramGames\Core\GameOption\GameOptionConfigurationCollection;

interface GameSetup
{
    public function getOption(string $key): GameOption;
    public function getAllOptions(): GameOptionCollection;
    public function configureOptions(GameOptionConfigurationCollection $configurations): void;
    public function isConfigured(): bool;
    public function getNumberOfPlayers(): GameOption;
    public function getAutostart(): GameOption;
}
