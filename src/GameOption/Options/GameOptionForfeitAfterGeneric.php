<?php

namespace MyDramGames\Core\GameOption\Options;

use MyDramGames\Core\GameOption\GameOptionBase;
use MyDramGames\Core\GameOption\Values\GameOptionValueForfeitAfter;

class GameOptionForfeitAfterGeneric extends GameOptionBase implements GameOptionForfeitAfter
{
    protected const ?string OPTION_KEY = 'forfeitAfter';
    protected const ?string OPTION_NAME = 'Forfeit After Disconnection';
    protected const ?string OPTION_DESCRIPTION = 'Forfeit the game specific time after player disconnects during game play';
    protected const ?string VALUE_CLASS = GameOptionValueForfeitAfter::class;
}
