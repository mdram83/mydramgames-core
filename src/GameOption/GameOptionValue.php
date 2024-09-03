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
}
