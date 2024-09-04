<?php

namespace MyDramGames\Core\Exceptions;

class GameOptionException extends MyDramGamesCoreException
{
    public const string MESSAGE_MISSING_VALUE = 'Option value not provided';
    public const string MESSAGE_INCOMPATIBLE_VALUE = 'Incorrect option value';
    public const string MESSAGE_NOT_CONFIGURED = 'Game option not configured yet';
    public const string MESSAGE_ALREADY_CONFIGURED = 'Game option already configured';
}
