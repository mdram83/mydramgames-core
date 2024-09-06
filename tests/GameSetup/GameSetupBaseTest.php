<?php

namespace Tests\GameSetup;

use MyDramGames\Core\Exceptions\GameSetupException;
use MyDramGames\Core\GameOption\GameOption;
use MyDramGames\Core\GameOption\GameOptionCollection;
use MyDramGames\Core\GameOption\GameOptionCollectionPowered;
use MyDramGames\Core\GameOption\GameOptionConfigurationCollection;
use MyDramGames\Core\GameOption\GameOptionConfigurationCollectionPowered;
use MyDramGames\Core\GameOption\GameOptionConfigurationGeneric;
use MyDramGames\Core\GameOption\GameOptionValue;
use MyDramGames\Core\GameOption\GameOptionValueCollection;
use MyDramGames\Core\GameOption\GameOptionValueCollectionPowered;
use MyDramGames\Core\GameOption\Options\GameOptionAutostart;
use MyDramGames\Core\GameOption\Options\GameOptionNumberOfPlayers;
use MyDramGames\Core\GameOption\Values\GameOptionValueAutostartGeneric;
use MyDramGames\Core\GameOption\Values\GameOptionValueForfeitAfterGeneric;
use MyDramGames\Core\GameOption\Values\GameOptionValueNumberOfPlayersGeneric;
use MyDramGames\Core\GameSetup\GameSetupBase;
use PHPUnit\Framework\TestCase;
use Tests\TestingHelper;

class GameSetupBaseTest extends TestCase
{
    protected GameSetupBase $setup;
    protected GameOptionCollection $optionsHandler;
    protected GameOptionValueCollection $valuesHandler;
    protected GameOptionConfigurationCollection $configurations;

    public function setUp(): void
    {
        $this->optionsHandler = new GameOptionCollectionPowered();
        $this->valuesHandler = new GameOptionValueCollectionPowered();
        $this->setup = TestingHelper::getGameSetupBaseClass($this->optionsHandler, $this->valuesHandler);

        $this->configurations = $this->getConfigurations();
    }

    public function getConfigurations(int $numberOfPlayers = 2): GameOptionConfigurationCollection
    {
        return new GameOptionConfigurationCollectionPowered(null, [
            new GameOptionConfigurationGeneric(
                'numberOfPlayers',
                GameOptionValueNumberOfPlayersGeneric::fromValue($numberOfPlayers)
            ),
            new GameOptionConfigurationGeneric(
                'autostart',
                GameOptionValueAutostartGeneric::Enabled
            ),
            new GameOptionConfigurationGeneric(
                'forfeitAfter',
                GameOptionValueForfeitAfterGeneric::Disabled
            )
        ]);
    }

    public function testGetOptionThrowExceptionWhenMissingOption(): void
    {
        $this->expectException(GameSetupException::class);
        $this->expectExceptionMessage(GameSetupException::MESSAGE_OPTION_NOT_SET);

        $this->setup->getOption('definitely-missing-123-option');
    }

    public function testGetOption(): void
    {
        $this->assertInstanceOf(GameOptionAutostart::class, $this->setup->getOption('autostart'));
    }

    public function testGetAllOptions(): void
    {
        $this->assertEquals(3, $this->setup->getAllOptions()->count());
    }

    public function testConfigureOptionsThrowExceptionWhenOptionNotInAvailable(): void
    {
        $this->expectException(GameSetupException::class);
        $this->expectExceptionMessage(GameSetupException::MESSAGE_OPTION_OUTSIDE);

        $optionMock = $this->createMock(GameOption::class);
        $optionMock->method('getKey')->willReturn('test-option-123');
        $valueMock = $this->createMock(GameOptionValue::class);
        $configuration = new GameOptionConfigurationGeneric($optionMock->getKey(), $valueMock);

        $this->setup->configureOptions($this->configurations->add($configuration));
    }

    public function testConfigureOptionThrowExceptionWhenValueExceedingDefaults(): void
    {
        $this->expectException(GameSetupException::class);
        $this->expectExceptionMessage(GameSetupException::MESSAGE_OPTION_OUTSIDE);

        $configuration = $this->getConfigurations(9);
        $this->setup->configureOptions($configuration);
    }

    public function testConfigureOptionThrowExceptionWhenRequiredConfigurationMissing(): void
    {
        $this->expectException(GameSetupException::class);
        $this->expectExceptionMessage(GameSetupException::MESSAGE_OPTION_NOT_SET);

        $configuration = $this->getConfigurations();
        $configuration->pullLast();
        $this->setup->configureOptions($configuration);
    }

    public function testGetConfiguredValue(): void
    {
        $this->setup->configureOptions($this->configurations);
        $this->assertSame(
            $this->configurations->getOne('autostart')->getGameOptionValue(),
            $this->setup->getAutostart()->getConfiguredValue()
        );
    }

    public function testIsConfiguredFalse(): void
    {
        $this->assertFalse($this->setup->isConfigured());
    }

    public function testIsConfiguredTrue(): void
    {
        $this->setup->configureOptions($this->configurations);
        $this->assertTrue($this->setup->isConfigured());
    }

    public function testIsSetUp(): void
    {
        $this->assertTrue($this->setup->isSetUp());
    }

    public function testGetNumberOfPlayers(): void
    {
        $this->assertInstanceOf(GameOptionNumberOfPlayers::class, $this->setup->getNumberOfPlayers());
    }

    public function testGetAutostart(): void
    {
        $this->assertInstanceOf(GameOptionAutostart::class, $this->setup->getAutostart());
    }
}
