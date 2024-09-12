<?php

namespace MyDramGames\Core\GameRecord;

use MyDramGames\Utils\Php\Collection\CollectionPoweredExtendable;

class GameRecordCollectionPowered extends CollectionPoweredExtendable implements GameRecordCollection
{
    protected const ?string TYPE_CLASS = GameRecord::class;
}
