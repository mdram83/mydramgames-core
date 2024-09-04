<?php

namespace Tests\GameOption\Values;

use MyDramGames\Core\GameOption\GameOptionValue;
use MyDramGames\Core\GameOption\Values\GameOptionValueForfeitAfterGeneric;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class GameOptionValueForfeitAfterGenericTest extends TestCase
{
    public function testInstanceOfGameOptions(): void
    {
        $reflection = new ReflectionClass(GameOptionValueForfeitAfterGeneric::class);
        $this->assertTrue($reflection->implementsInterface(GameOptionValue::class));
    }

    public function testGetValue(): void
    {
        $disabled = GameOptionValueForfeitAfterGeneric::Disabled;
        $minute1 = GameOptionValueForfeitAfterGeneric::Minute;
        $minute5 = GameOptionValueForfeitAfterGeneric::Minutes5;
        $minute10 = GameOptionValueForfeitAfterGeneric::Minutes10;
        $hour1 = GameOptionValueForfeitAfterGeneric::Hour;
        $day1 = GameOptionValueForfeitAfterGeneric::Day;

        $this->assertEquals($disabled->value, $disabled->getValue());
        $this->assertEquals($minute1->value, $minute1->getValue());
        $this->assertEquals($minute5->value, $minute5->getValue());
        $this->assertEquals($minute10->value, $minute10->getValue());
        $this->assertEquals($hour1->value, $hour1->getValue());
        $this->assertEquals($day1->value, $day1->getValue());
    }

    public function testGetLabel(): void
    {
        $disabled = GameOptionValueForfeitAfterGeneric::Disabled;
        $minute1 = GameOptionValueForfeitAfterGeneric::Minute;
        $minute5 = GameOptionValueForfeitAfterGeneric::Minutes5;
        $minute10 = GameOptionValueForfeitAfterGeneric::Minutes10;
        $hour1 = GameOptionValueForfeitAfterGeneric::Hour;
        $day1 = GameOptionValueForfeitAfterGeneric::Day;

        $this->assertEquals('Disabled', $disabled->getLabel());
        $this->assertEquals('1 Minute', $minute1->getLabel());
        $this->assertEquals('5 Minutes', $minute5->getLabel());
        $this->assertEquals('10 Minutes', $minute10->getLabel());
        $this->assertEquals('1 Hour', $hour1->getLabel());
        $this->assertEquals('1 Day', $day1->getLabel());
    }

    public function testFromValue(): void
    {
        $this->assertInstanceOf(
            GameOptionValueForfeitAfterGeneric::class,
            GameOptionValueForfeitAfterGeneric::fromValue(GameOptionValueForfeitAfterGeneric::Disabled->value)
        );
    }
}
