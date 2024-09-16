<?php

namespace MyDramGames\Core\Exceptions;

use MyDramGames\Core\Exceptions\MyDramGamesCoreException;

class GameIndexException extends MyDramGamesCoreException
{
    public const string MESSAGE_MISSING_SLUG = 'Requested slug is missing';
}
