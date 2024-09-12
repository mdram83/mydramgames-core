<?php

namespace MyDramGames\Core\Exceptions;

class GameResultProviderException extends MyDramGamesCoreException
{
    public const string MESSAGE_INCORRECT_DATA_PARAMETER = 'Incorrect data parameter';
    public const string MESSAGE_RESULTS_ALREADY_SET = 'Result already provided';
    public const string MESSAGE_RESULT_NOT_SET = 'Can not generate records without game result';
    public const string MESSAGE_RECORD_ALREADY_SET = 'Game records already created';
}
