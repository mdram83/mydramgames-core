<?php

namespace MyDramGames\Core\GameOption;

interface GameOptionConfiguration
{
    /**
     * Key of option to which value is related to
     * @return string
     */
    public function getGameOptionKey(): string;

    /**
     * Value used to configure the option
     * @return GameOptionValue
     */
    public function getGameOptionValue(): GameOptionValue;
}
