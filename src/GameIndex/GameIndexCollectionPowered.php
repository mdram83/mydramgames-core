<?php

namespace MyDramGames\Core\GameIndex;

use MyDramGames\Core\GameIndex\GameIndexCollection;
use MyDramGames\Utils\Php\Collection\CollectionPoweredExtendable;

class GameIndexCollectionPowered extends CollectionPoweredExtendable implements GameIndexCollection
{
    protected const ?string TYPE_CLASS = GameIndex::class;
    protected const int KEY_MODE = self::KEYS_METHOD;

    protected function getItemKey(mixed $item): mixed
    {
        return $item->getSlug();
    }
}
