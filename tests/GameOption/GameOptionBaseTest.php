<?php

namespace Tests\GameOption;

use MyDramGames\Core\Exceptions\GameOptionException;
use MyDramGames\Core\GameOption\GameOption;
use MyDramGames\Core\GameOption\GameOptionType;
use MyDramGames\Core\GameOption\GameOptionValue;
use MyDramGames\Core\GameOption\GameOptionValueCollection;
use MyDramGames\Core\GameOption\GameOptionValueCollectionPowered;
use MyDramGames\Core\GameOption\Values\GameOptionValueAutostartGeneric;
use PHPUnit\Framework\TestCase;
use Tests\TestingHelper;

class GameOptionBaseTest extends TestCase
{
    protected GameOptionValueCollection $available;
    protected GameOptionValue $default;
    protected GameOptionValue $configured;
    protected GameOption $option;
    protected GameOptionType $type;

    public function setUp(): void
    {
        $this->default = GameOptionValueAutostartGeneric::Enabled;
        $this->configured = GameOptionValueAutostartGeneric::Disabled;
        $this->available = new GameOptionValueCollectionPowered(null, [$this->default, $this->configured]);
        $this->type = $this->createMock(GameOptionType::class);

        $this->option = TestingHelper::getGameOptionBaseClass($this->available, $this->default, $this->type);
    }

    public function testGetKey(): void
    {
        $this->assertNotNull($this->option->getKey());
        $this->assertIsString($this->option->getKey());
    }

    public function testGetName(): void
    {
        $this->assertNotNull($this->option->getName());
        $this->assertIsString($this->option->getName());
    }

    public function testGetDescription(): void
    {
        $this->assertNotNull($this->option->getDescription());
        $this->assertIsString($this->option->getDescription());
    }

    public function testGetType(): void
    {
        $this->assertInstanceOf(GameOptionType::class, $this->option->getType());
    }

    public function testConstructorThrowExceptionWhenAvailableValuesAreNotAutostart(): void
    {
        $this->expectException(GameOptionException::class);
        $this->expectExceptionMessage(GameOptionException::MESSAGE_INCOMPATIBLE_VALUE);

        $availableOption = $this->createMock(GameOptionValue::class);
        $availableCollection = new GameOptionValueCollectionPowered(null, [$availableOption]);

        TestingHelper::getGameOptionBaseClass($availableCollection, $this->default, $this->type);
    }

    public function testConstructorThrowExceptionWhenAvailableValuesAreEmpty(): void
    {
        $this->expectException(GameOptionException::class);
        $this->expectExceptionMessage(GameOptionException::MESSAGE_MISSING_VALUE);

        $availableCollection = new GameOptionValueCollectionPowered();

        TestingHelper::getGameOptionBaseClass($availableCollection, $this->default, $this->type);
    }

    public function testGetDefaultValue(): void
    {
        $this->assertSame($this->default, $this->option->getDefaultValue());
    }

    public function testGetAvailableValues(): void
    {
        $this->assertSame($this->available, $this->option->getAvailableValues());
    }

    public function testGetConfiguredValueThrowExceptionIfNotSet(): void
    {
        $this->expectException(GameOptionException::class);
        $this->expectExceptionMessage(GameOptionException::MESSAGE_NOT_CONFIGURED);

        $this->option->getConfiguredValue();
    }

    public function testSetConfiguredValueThrowExceptionIfAlreadySet(): void
    {
        $this->expectException(GameOptionException::class);
        $this->expectExceptionMessage(GameOptionException::MESSAGE_ALREADY_CONFIGURED);

        $this->option->setConfiguredValue($this->configured);
        $this->option->setConfiguredValue($this->configured);
    }

    public function testGetConfiguredValue(): void
    {
        $this->option->setConfiguredValue($this->configured);
        $this->assertSame($this->configured, $this->option->getConfiguredValue());
    }

    public function testIsConfiguredFalse(): void
    {
        $this->assertFalse($this->option->isConfigured());
    }

    public function testIsConfiguredTrue(): void
    {
        $this->option->setConfiguredValue($this->configured);
        $this->assertTrue($this->option->isConfigured());
    }
}
