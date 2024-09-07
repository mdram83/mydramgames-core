<?php

namespace MyDramGames\Core\Exceptions;

use Exception;

class GameMoveException extends Exception
{
    public const string MESSAGE_INVALID_MOVE_PARAMS = 'Invalid move parameters';
}
