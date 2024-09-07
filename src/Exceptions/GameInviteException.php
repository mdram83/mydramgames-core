<?php

namespace MyDramGames\Core\Exceptions;

class GameInviteException extends MyDramGamesCoreException
{
    public const string MESSAGE_GAME_NOT_FOUND = 'GameInvite not found';

    public const string MESSAGE_PLAYER_ALREADY_ADDED = 'Player already added';
    public const string MESSAGE_TOO_MANY_PLAYERS = 'Number of players exceeded';
    public const string MESSAGE_NO_OF_PLAYERS_EXCEED_DEF = 'Number of players not matching game definition';
    public const string MESSAGE_NO_OF_PLAYERS_NOT_SET = 'Number of players not set';
    public const string MESSAGE_NO_OF_PLAYERS_WAS_SET = 'Number of players already set';
    public const string MESSAGE_PLAYER_TYPE_UNSET = 'Player type unknown';

    public const string MESSAGE_HOST_ALREADY_ADDED = 'Host already added';
    public const string MESSAGE_HOST_NOT_SET = 'Host not set';

    public const string MESSAGE_GAME_BOX_NOT_SET = 'GameBox not set';
    public const string MESSAGE_GAME_BOX_ALREADY_SET = 'GameBox already set';

    public const string MESSAGE_GAME_SETUP_NOT_SET = 'Options not set';
    public const string MESSAGE_GAME_SETUP_ALREADY_SET = 'Options already set';
}
