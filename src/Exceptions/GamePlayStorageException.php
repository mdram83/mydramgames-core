<?php

namespace MyDramGames\Core\Exceptions;

class GamePlayStorageException extends MyDramGamesCoreException
{
    public const string MESSAGE_NOT_FOUND = 'GamePlay not found';
    public const string MESSAGE_INVALID_INVITE = 'GameInvite invalid';
    public const string MESSAGE_INVITE_NOT_SET = 'GameInvite not set';
    public const string MESSAGE_SETUP_ALREADY_SET = 'Setup already set';
    public const string MESSAGE_FINISH_ALREADY_SET = 'Finish already set';
}
