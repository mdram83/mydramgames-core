<?php

namespace Tests\GameOption;

use MyDramGames\Core\Exceptions\GameOptionConfigurationException;
use MyDramGames\Core\GameOption\GameOptionConfigurationGeneric;
use MyDramGames\Core\GameOption\GameOptionValue;
use PHPUnit\Framework\TestCase;

class GameOptionConfigurationGenericTest extends TestCase
{
    protected GameOptionConfigurationGeneric $configuration;
    protected GameOptionValue $value;
    protected string $key;

    public function setUp(): void
    {
        $this->value = $this->createMock(GameOptionValue::class);
        $this->key = 'autostart';
        $this->configuration = new GameOptionConfigurationGeneric($this->key, $this->value);
    }

    public function testGetGameOptionKey(): void
    {
        $this->assertEquals($this->key, $this->configuration->getGameOptionKey());
    }

    public function testGetGameOptionValue(): void
    {
        $this->assertSame($this->value, $this->configuration->getGameOptionValue());
    }
}
