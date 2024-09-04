<?php

namespace Tests\GameOption\Values;

use MyDramGames\Core\GameOption\GameOptionValue;
use MyDramGames\Core\GameOption\Values\GameOptionValueNumberOfPlayersGeneric;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class GameOptionValueNumberOfPlayersTestGeneric extends TestCase
{
    public function testInstanceOfGameOptions(): void
    {
        $reflection = new ReflectionClass(GameOptionValueNumberOfPlayersGeneric::class);
        $this->assertTrue($reflection->implementsInterface(GameOptionValue::class));
    }

    public function testGetValue(): void
    {
        $players2 = GameOptionValueNumberOfPlayersGeneric::Players002;
        $players3 = GameOptionValueNumberOfPlayersGeneric::Players003;
        $players4 = GameOptionValueNumberOfPlayersGeneric::Players004;
        $players5 = GameOptionValueNumberOfPlayersGeneric::Players005;
        $players6 = GameOptionValueNumberOfPlayersGeneric::Players006;
        $players7 = GameOptionValueNumberOfPlayersGeneric::Players007;
        $players8 = GameOptionValueNumberOfPlayersGeneric::Players008;
        $players9 = GameOptionValueNumberOfPlayersGeneric::Players009;

        $this->assertEquals($players2->value, $players2->getValue());
        $this->assertEquals($players3->value, $players3->getValue());
        $this->assertEquals($players4->value, $players4->getValue());
        $this->assertEquals($players5->value, $players5->getValue());
        $this->assertEquals($players6->value, $players6->getValue());
        $this->assertEquals($players7->value, $players7->getValue());
        $this->assertEquals($players8->value, $players8->getValue());
        $this->assertEquals($players9->value, $players9->getValue());
    }

    public function testGetLabel(): void
    {
        $players2 = GameOptionValueNumberOfPlayersGeneric::Players002;
        $players3 = GameOptionValueNumberOfPlayersGeneric::Players003;
        $players4 = GameOptionValueNumberOfPlayersGeneric::Players004;
        $players5 = GameOptionValueNumberOfPlayersGeneric::Players005;
        $players6 = GameOptionValueNumberOfPlayersGeneric::Players006;
        $players7 = GameOptionValueNumberOfPlayersGeneric::Players007;
        $players8 = GameOptionValueNumberOfPlayersGeneric::Players008;
        $players9 = GameOptionValueNumberOfPlayersGeneric::Players009;

        $this->assertEquals('2 Players', $players2->getLabel());
        $this->assertEquals('3 Players', $players3->getLabel());
        $this->assertEquals('4 Players', $players4->getLabel());
        $this->assertEquals('5 Players', $players5->getLabel());
        $this->assertEquals('6 Players', $players6->getLabel());
        $this->assertEquals('7 Players', $players7->getLabel());
        $this->assertEquals('8 Players', $players8->getLabel());
        $this->assertEquals('9 Players', $players9->getLabel());
    }
}
