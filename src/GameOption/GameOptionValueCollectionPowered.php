<?php

namespace MyDramGames\Core\GameOption;

use MyDramGames\Utils\Php\Collection\CollectionPoweredExtendable;

class GameOptionValueCollectionPowered extends CollectionPoweredExtendable implements GameOptionValueCollection
{
    protected const ?string TYPE_CLASS = GameOptionValue::class;
    protected const int KEY_MODE = self::KEYS_LOOSE;
}