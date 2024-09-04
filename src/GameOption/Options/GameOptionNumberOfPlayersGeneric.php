<?php

namespace MyDramGames\Core\GameOption\Options;

use MyDramGames\Core\GameOption\GameOptionBase;
use MyDramGames\Core\GameOption\Values\GameOptionValueForfeitAfter;
use MyDramGames\Core\GameOption\Values\GameOptionValueNumberOfPlayers;

class GameOptionNumberOfPlayersGeneric extends GameOptionBase implements GameOptionNumberOfPlayers
{
    protected const ?string OPTION_KEY = 'numberOfPlayers';
    protected const ?string OPTION_NAME = 'Number of players';
    protected const ?string OPTION_DESCRIPTION = 'How many players you want to play with (including yourself).';
    protected const ?string VALUE_CLASS = GameOptionValueNumberOfPlayers::class;
}
