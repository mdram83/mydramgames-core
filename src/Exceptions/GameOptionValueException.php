<?php

namespace MyDramGames\Core\Exceptions;

use Exception;

class GameOptionValueException extends Exception
{
    public const string MESSAGE_MISSING_VALUE = 'Value does not exist';
}
