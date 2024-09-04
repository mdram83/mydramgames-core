<?php

namespace MyDramGames\Core\GameOption;

interface GameOptionValue
{
    /**
     * Returns actual value
     * @return int|string|null
     */
    public function getValue(): int|string|null;

    /**
     * Returns label for user friendly messages (e.g. '1 Hour' instead of `3600`)
     * @return string
     */
    public function getLabel(): string;

    /**
     * Allow to create GameOptionValue object from specific value
     * @param int|string|null $value
     * @return static
     */
    public static function fromValue(int|string|null $value): static;
}
