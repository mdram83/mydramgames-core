<?php

namespace MyDramGames\Core\GameOption;

interface GameOptionType
{
    /**
     * Provides value of specific type, e.g. 'checkbox' or 'radio'.
     * @return int|string|null
     */
    public function getValue(): int|string|null;
}