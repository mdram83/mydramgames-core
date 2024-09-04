<?php

namespace MyDramGames\Core\GameOption;

interface GameOptionType
{
    /**
     * Provides value of specific type, e.g. 'checkbox' or 'radio'.
     * @return int|string|null
     */
    public function getValue(): int|string|null;

    /**
     * Allow to create GameOptionType object from specific value
     * @param int|string|null $value
     * @return static
     */
    public static function fromValue(int|string|null $value): static;
}