<?php

namespace MyDramGames\Core\GameOption\Values;

use MyDramGames\Core\GameOption\GameOptionValue;
use MyDramGames\Utils\Php\Enum\GetValueBackedEnumTrait;

enum GameOptionValueNumberOfPlayers: int implements GameOptionValue
{
    use GetValueBackedEnumTrait;

    case Players002 = 2;
    case Players003 = 3;
    case Players004 = 4;
    case Players005 = 5;
    case Players006 = 6;
    case Players007 = 7;
    case Players008 = 8;
    case Players009 = 9;

    public function getLabel(): string
    {
        return match($this) {
            self::Players002 => '2 Players',
            self::Players003 => '3 Players',
            self::Players004 => '4 Players',
            self::Players005 => '5 Players',
            self::Players006 => '6 Players',
            self::Players007 => '7 Players',
            self::Players008 => '8 Players',
            self::Players009 => '9 Players',
        };
    }
}
