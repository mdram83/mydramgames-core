<?php

namespace MyDramGames\Core\Exceptions;

class GamePhaseException extends MyDramGamesCoreException
{
    public const string MESSAGE_INCORRECT_KEY = 'Incorrect key';
    public const string MESSAGE_PHASE_SINGLE_ATTEMPT = 'Phase can has only final attempt';
}
