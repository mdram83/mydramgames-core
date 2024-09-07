<?php

namespace MyDramGames\Core\Exceptions;

class GamePlayException extends MyDramGamesCoreException
{
    public const string MESSAGE_STORAGE_INCORRECT = 'Incorrect storage configuration';
    public const string MESSAGE_MISSING_PLAYERS = 'Incorrect players configuration';
    public const string MESSAGE_NOT_PLAYER = 'Incorrect player';
    public const string MESSAGE_NOT_CURRENT_PLAYER = 'It is not Player move now';
    public const string MESSAGE_INCOMPATIBLE_MOVE = 'Move configuration incompatible with game';
    public const string MESSAGE_MOVE_ON_FINISHED_GAME = 'Can not make move on finished game';
}
