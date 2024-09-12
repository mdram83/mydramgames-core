<?php

namespace MyDramGames\Core\Exceptions;

class GameRecordException extends MyDramGamesCoreException
{
    public const string MESSAGE_DUPLICATE_RECORD = 'Game record duplicated';
    public const string MESSAGE_MISSING_INVITE = 'Incorrect game invite';
}
