<?php

namespace MyDramGames\Core\Exceptions;

class GameBoxException extends MyDramGamesCoreException
{
    public const string MESSAGE_GAME_BOX_MISSING = 'Missing game configuration';
    public const string MESSAGE_INCORRECT_CONFIGURATION = 'Incorrect game configuration';
}
