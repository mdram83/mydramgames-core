<?php

namespace Tests\GameOption\Values;

use MyDramGames\Core\Exceptions\GameOptionValueException;
use MyDramGames\Core\GameOption\GameOptionValue;
use MyDramGames\Core\GameOption\Values\GameOptionValueAutostartGeneric;
use MyDramGames\Utils\Exceptions\BackedEnumException;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class GameOptionValueAutostartGenericTest extends TestCase
{
    public function testInstanceOfGameOptions(): void
    {
        $reflection = new ReflectionClass(GameOptionValueAutostartGeneric::class);
        $this->assertTrue($reflection->implementsInterface(GameOptionValue::class));
    }

    public function testGetValue(): void
    {
        $enabled = GameOptionValueAutostartGeneric::Enabled;
        $disabled = GameOptionValueAutostartGeneric::Disabled;

        $this->assertEquals($enabled->value, $enabled->getValue());
        $this->assertEquals($disabled->value, $disabled->getValue());
    }

    public function testGetLabel(): void
    {
        $enabled = GameOptionValueAutostartGeneric::Enabled;
        $disabled = GameOptionValueAutostartGeneric::Disabled;

        $this->assertEquals('Enabled', $enabled->getLabel());
        $this->assertEquals('Disabled', $disabled->getLabel());
    }

    public function testFromValue(): void
    {
        $this->assertInstanceOf(
            GameOptionValueAutostartGeneric::class,
            GameOptionValueAutostartGeneric::fromValue(GameOptionValueAutostartGeneric::Enabled->value)
        );
        $this->assertInstanceOf(
            GameOptionValueAutostartGeneric::class,
            GameOptionValueAutostartGeneric::fromValue(GameOptionValueAutostartGeneric::Disabled->value)
        );
    }
}
