<?php

namespace MyDramGames\Core\GameBox;

use MyDramGames\Utils\Php\Collection\CollectionPoweredExtendable;

class GameBoxCollectionPowered extends CollectionPoweredExtendable implements GameBoxCollection
{
    protected const ?string TYPE_CLASS = GameBox::class;
    protected const int KEY_MODE = self::KEYS_METHOD;

    protected function getItemKey(mixed $item): mixed
    {
        return $item->getSlug();
    }
}
