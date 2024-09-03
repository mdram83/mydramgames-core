<?php

namespace Tests\GameOption;

use MyDramGames\Core\GameOption\GameOptionType;
use MyDramGames\Core\GameOption\GameOptionTypeGeneric;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class GameOptionTypeGenericTest extends TestCase
{
    public function testInstanceOfGameOptionType(): void
    {
        $reflection = new ReflectionClass(GameOptionTypeGeneric::class);
        $this->assertTrue($reflection->implementsInterface(GameOptionType::class));
    }

    public function testGetValue(): void
    {
        $type = GameOptionTypeGeneric::Checkbox;
        $this->assertEquals($type->value, $type->getValue());
    }

    public function testDefinition(): void
    {
        $types = array_map(fn($type) => $type->getValue(), GameOptionTypeGeneric::cases());
        $this->assertEquals(['radio', 'select', 'checkbox'], $types);
    }
}
