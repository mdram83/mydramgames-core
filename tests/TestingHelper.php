<?php

namespace Tests;

use MyDramGames\Core\GameOption\GameOption;
use MyDramGames\Core\GameOption\GameOptionBase;
use MyDramGames\Core\GameOption\GameOptionCollection;
use MyDramGames\Core\GameOption\GameOptionType;
use MyDramGames\Core\GameOption\GameOptionTypeGeneric;
use MyDramGames\Core\GameOption\GameOptionValue;
use MyDramGames\Core\GameOption\GameOptionValueCollection;
use MyDramGames\Core\GameOption\Options\GameOptionAutostartGeneric;
use MyDramGames\Core\GameOption\Options\GameOptionForfeitAfterGeneric;
use MyDramGames\Core\GameOption\Options\GameOptionNumberOfPlayersGeneric;
use MyDramGames\Core\GameOption\Values\GameOptionValueAutostartGeneric;
use MyDramGames\Core\GameOption\Values\GameOptionValueForfeitAfterGeneric;
use MyDramGames\Core\GameOption\Values\GameOptionValueNumberOfPlayersGeneric;
use MyDramGames\Core\GameSetup\GameSetup;
use MyDramGames\Core\GameSetup\GameSetupBase;

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
            protected const ?string VALUE_CLASS = GameOptionValueAutostartGeneric::class;

            public function __construct(
                GameOptionValueCollection $available,
                GameOptionValueAutostartGeneric $default,
                GameOptionType $type
            )
            {
                parent::__construct($available, $default, $type);
            }
        };
    }

    public static function getGameSetupBaseClass(
        GameOptionCollection $optionsHandler,
        GameOptionValueCollection $valuesHandler
    ): GameSetupBase
    {
        return new class($optionsHandler, $valuesHandler) extends GameSetupBase implements GameSetup
        {
            protected function prepareDefaultOptions(GameOptionValueCollection $valuesHandler): array
            {
                return
                    [
                        new GameOptionNumberOfPlayersGeneric(
                            $valuesHandler->clone()->reset([
                                GameOptionValueNumberOfPlayersGeneric::Players002,
                                GameOptionValueNumberOfPlayersGeneric::Players003,
                            ]),
                            GameOptionValueNumberOfPlayersGeneric::Players002,
                            GameOptionTypeGeneric::Radio
                        ),

                        new GameOptionAutostartGeneric(
                            $valuesHandler->clone()->reset([
                                GameOptionValueAutostartGeneric::Enabled,
                                GameOptionValueAutostartGeneric::Disabled
                            ]),
                            GameOptionValueAutostartGeneric::Enabled,
                            GameOptionTypeGeneric::Checkbox
                        ),

                        new GameOptionForfeitAfterGeneric(
                            $valuesHandler->clone()->reset([
                                GameOptionValueForfeitAfterGeneric::Disabled,
                            ]),
                            GameOptionValueForfeitAfterGeneric::Disabled,
                            GameOptionTypeGeneric::Radio
                        ),

                    ];
            }
        };
    }
}