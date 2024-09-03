<?php

namespace MyDramGames\Core\GameOption\Values;

use MyDramGames\Core\GameOption\GameOptionValue;
use MyDramGames\Utils\Php\Enum\GetValueBackedEnumTrait;

enum GameOptionValueAutostart: int implements GameOptionValue
{
    use GetValueBackedEnumTrait;

    case Enabled = 1;
    case Disabled = 0;

    public function getLabel(): string
    {
        return match($this) {
            self::Enabled => 'Enabled',
            self::Disabled => 'Disabled',
        };
    }
}
