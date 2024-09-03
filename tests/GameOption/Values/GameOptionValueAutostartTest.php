<?php

namespace Tests\GameOption\Values;

use MyDramGames\Core\GameOption\GameOptionValue;
use MyDramGames\Core\GameOption\Values\GameOptionValueAutostart;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class GameOptionValueAutostartTest extends TestCase
{
    public function testInstanceOfGameOptions(): void
    {
        $reflection = new ReflectionClass(GameOptionValueAutostart::class);
        $this->assertTrue($reflection->implementsInterface(GameOptionValue::class));
    }

    public function testGetValue(): void
    {
        $enabled = GameOptionValueAutostart::Enabled;
        $disabled = GameOptionValueAutostart::Disabled;

        $this->assertEquals($enabled->value, $enabled->getValue());
        $this->assertEquals($disabled->value, $disabled->getValue());
    }

    public function testGetLabel(): void
    {
        $enabled = GameOptionValueAutostart::Enabled;
        $disabled = GameOptionValueAutostart::Disabled;

        $this->assertEquals('Enabled', $enabled->getLabel());
        $this->assertEquals('Disabled', $disabled->getLabel());
    }
}
