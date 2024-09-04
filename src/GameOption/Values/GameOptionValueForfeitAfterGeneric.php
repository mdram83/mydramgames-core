<?php

namespace MyDramGames\Core\GameOption\Values;

use MyDramGames\Utils\Php\Enum\FromValueBackedEnumTrait;
use MyDramGames\Utils\Php\Enum\GetValueBackedEnumTrait;

enum GameOptionValueForfeitAfterGeneric: int implements GameOptionValueForfeitAfter
{
    use GetValueBackedEnumTrait;
    use FromValueBackedEnumTrait;

    case Disabled  = 0;
    case Minute    = 60;
    case Minutes5  = 300;
    case Minutes10 = 600;
    case Hour      = 3600;
    case Day       = 86400;

    public function getLabel(): string
    {
        return match($this) {
            self::Disabled => 'Disabled',
            self::Minute => '1 Minute',
            self::Minutes5 => '5 Minutes',
            self::Minutes10 => '10 Minutes',
            self::Hour => '1 Hour',
            self::Day => '1 Day',
        };
    }
}
