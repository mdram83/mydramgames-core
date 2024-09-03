<?php

namespace MyDramGames\Core\GameOption;

interface GameOptionType
{
    public function getValue(): int|string|null;
}