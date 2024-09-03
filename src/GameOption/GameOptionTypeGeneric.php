<?php

namespace MyDramGames\Core\GameOption;

use MyDramGames\Utils\Php\Enum\GetValueBackedEnumTrait;

enum GameOptionTypeGeneric: string implements GameOptionType
{
    use GetValueBackedEnumTrait;

    case Radio = 'radio';
    case Select = 'select';
    case Checkbox = 'checkbox';
}
