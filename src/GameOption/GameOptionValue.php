<?php

namespace MyDramGames\Core\GameOption;

interface GameOptionValue
{
    public function getValue(): int|string|null;
    public function getLabel(): string;
}
