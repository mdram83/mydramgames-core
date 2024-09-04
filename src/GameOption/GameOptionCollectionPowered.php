<?php

namespace MyDramGames\Core\GameOption;

use MyDramGames\Core\GameOption\GameOptionCollection;
use MyDramGames\Utils\Php\Collection\CollectionPoweredExtendable;

class GameOptionCollectionPowered extends CollectionPoweredExtendable implements GameOptionCollection
{
    protected const ?string TYPE_CLASS = GameOption::class;
    protected const int KEY_MODE = self::KEYS_METHOD;

    protected function getItemKey(mixed $item): mixed
    {
        return $item->getKey();
    }
}
