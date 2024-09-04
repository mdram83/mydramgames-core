<?php

namespace MyDramGames\Core\Exceptions;

class GameSetupException extends MyDramGamesCoreException
{
    public const string MESSAGE_OPTION_NOT_SET = 'Required option not set';
    public const string MESSAGE_OPTION_INCORRECT = 'Options incorrectly set';
    public const string MESSAGE_OPTION_OUTSIDE = 'Option(s) is/are exceeding game available values';
    public const string MESSAGE_NO_ABS_FACTORY = 'Game configuration incomplete';
}
