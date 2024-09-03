<?php

namespace Tests;

use MyDramGames\Core\GameOption\GameOption;
use MyDramGames\Core\GameOption\GameOptionBase;
use MyDramGames\Core\GameOption\GameOptionType;
use MyDramGames\Core\GameOption\GameOptionValue;
use MyDramGames\Core\GameOption\GameOptionValueCollection;
use MyDramGames\Core\GameOption\Values\GameOptionValueAutostart;

class TestingHelper
{
    public static function getGameOptionBaseClass(
        GameOptionValueCollection $available,
        GameOptionValue $default,
        GameOptionType $type,
    ): GameOption
    {
        return new class($available, $default, $type) extends GameOptionBase implements GameOption
        {
            protected const ?string OPTION_KEY = 'test-key';
            protected const ?string OPTION_NAME = 'test-name';
            protected const ?string OPTION_DESCRIPTION = 'test-description';
            protected const ?string VALUE_CLASS = GameOptionValueAutostart::class;

            public function __construct(
                GameOptionValueCollection $available,
                GameOptionValueAutostart $default,
                GameOptionType $type
            )
            {
                parent::__construct($available, $default, $type);
            }
        };
    }
}