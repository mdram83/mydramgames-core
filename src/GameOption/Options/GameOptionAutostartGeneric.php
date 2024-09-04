<?php

namespace MyDramGames\Core\GameOption\Options;

use MyDramGames\Core\GameOption\GameOptionBase;
use MyDramGames\Core\GameOption\Values\GameOptionValueAutostart;

class GameOptionAutostartGeneric extends GameOptionBase implements GameOptionAutostart
{
    protected const ?string OPTION_KEY = 'autostart';
    protected const ?string OPTION_NAME = 'Autostart';
    protected const ?string OPTION_DESCRIPTION = 'Start game automatically when all players are ready';
    protected const ?string VALUE_CLASS = GameOptionValueAutostart::class;
}
