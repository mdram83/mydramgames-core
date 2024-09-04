<?php

namespace Tests\GameOption\Values;

use MyDramGames\Core\GameOption\GameOptionValue;
use MyDramGames\Core\GameOption\Values\GameOptionValueAutostartGeneric;
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
}
