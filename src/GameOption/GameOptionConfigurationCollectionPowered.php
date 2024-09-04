<?php

namespace MyDramGames\Core\GameOption;

use MyDramGames\Utils\Php\Collection\CollectionPoweredExtendable;

class GameOptionConfigurationCollectionPowered
    extends CollectionPoweredExtendable
    implements GameOptionConfigurationCollection
{
    protected const ?string TYPE_CLASS = GameOptionConfiguration::class;
    protected const int KEY_MODE = self::KEYS_METHOD;

    protected function getItemKey(mixed $item): mixed
    {
        return $item->getGameOptionKey();
    }
}