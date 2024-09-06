<?php

namespace Tests\GameBox;

use MyDramGames\Core\Exceptions\GameBoxException;
use MyDramGames\Core\GameBox\GameBox;
use MyDramGames\Core\GameBox\GameBoxGeneric;
use MyDramGames\Core\GameOption\GameOptionCollectionPowered;
use MyDramGames\Core\GameOption\GameOptionTypeGeneric;
use MyDramGames\Core\GameOption\GameOptionValueCollectionPowered;
use MyDramGames\Core\GameOption\Options\GameOptionNumberOfPlayers;
use MyDramGames\Core\GameOption\Values\GameOptionValueNumberOfPlayersGeneric;
use MyDramGames\Core\GameSetup\GameSetup;
use PHPUnit\Framework\TestCase;
use Tests\TestingHelper;

class GameBoxGenericTest extends TestCase
{
    protected GameBoxGeneric $box;
    protected string $slug;
    protected string $name;
    protected GameSetup $gameSetup;
    protected bool $isActive;
    protected bool $isPremium;
    protected ?string $description;
    protected ?int $durationInMinutes;
    protected ?int $minPlayerAge;

    public function setUp(): void
    {
        $this->slug = 'test-gamebox';
        $this->name = 'Test Game';
        $this->isActive = true;
        $this->isPremium = false;
        $this->description = 'Test Game Description';
        $this->durationInMinutes = 30;
        $this->minPlayerAge = 10;

        $this->gameSetup = $this->getGameSetup();

        $this->box = $this->getGameBox();
    }

    protected function getGameBox(): GameBoxGeneric
    {
        return new GameBoxGeneric(
            $this->slug,
            $this->name,
            $this->gameSetup,
            $this->isActive,
            $this->isPremium,
            $this->description,
            $this->durationInMinutes,
            $this->minPlayerAge
        );
    }

    protected function getGameSetup(array $numberOfPlayersValues = [2]): GameSetup
    {
        $setup = $this->createMock(GameSetup::class);
        $option = $this->createMock(GameOptionNumberOfPlayers::class);
        $values = new GameOptionValueCollectionPowered();
        foreach ($numberOfPlayersValues as $value) {
            $values->add(GameOptionValueNumberOfPlayersGeneric::fromValue($value));
        }
        $setup->method('getNumberOfPlayers')->willReturn($option);
        $option->method('getAvailableValues')->willReturn($values);

        return $setup;
    }

    public function testConstruct(): void
    {
        $this->assertInstanceOf(GameBox::class, $this->box);
    }

    public function testGetSlugThrowExceptionWhenSlugIsEmpty(): void
    {
        $this->expectException(GameBoxException::class);
        $this->expectExceptionMessage(GameBoxException::MESSAGE_INCORRECT_CONFIGURATION);

        $this->slug = '';
        $box = $this->getGameBox();
        $box->getSlug();
    }

    public function testGetSlug(): void
    {
        $this->assertEquals($this->slug, $this->box->getSlug());
    }

    public function testGetNameThrowExceptionWhenNameIsEmpty(): void
    {
        $this->expectException(GameBoxException::class);
        $this->expectExceptionMessage(GameBoxException::MESSAGE_INCORRECT_CONFIGURATION);

        $this->name = '';
        $box = $this->getGameBox();
        $box->getName();
    }

    public function testGetName(): void
    {
        $this->assertEquals($this->name, $this->box->getName());
    }

    public function testGetDescription(): void
    {
        $this->assertEquals($this->description, $this->box->getDescription());
    }

    public function testGetNumberOfPlayersDescriptionWithOneNumber(): void
    {
        $this->assertEquals('2', $this->box->getNumberOfPlayersDescription());
    }

    public function testGetNumberOfPlayersDescriptionWithConsecutiveNumbers(): void
    {
        $this->gameSetup = $this->getGameSetup([2, 3, 4]);
        $this->box = $this->getGameBox();

        $this->assertEquals('2-4', $this->box->getNumberOfPlayersDescription());
    }

    public function testGetNumberOfPlayersDescriptionWithNonConsecutiveNumbers(): void
    {
        $this->gameSetup = $this->getGameSetup([2, 4, 6]);
        $this->box = $this->getGameBox();

        $this->assertEquals('2, 4, 6', $this->box->getNumberOfPlayersDescription());
    }

    public function testGetDurationInMinutes(): void
    {
        $this->assertEquals($this->durationInMinutes, $this->box->getDurationInMinutes());
    }

    public function testGetMinPlayerAge(): void
    {
        $this->assertEquals($this->minPlayerAge, $this->box->getMinPlayerAge());
    }

    public function testIsActive(): void
    {
        $this->assertEquals($this->isActive, $this->box->isActive());
    }

    public function testIsPremium(): void
    {
        $this->assertEquals($this->isPremium, $this->box->isPremium());
    }

    public function testGetGameSetup(): void
    {
        $this->assertSame($this->gameSetup, $this->box->getGameSetup());
    }

    public function testToArray(): void
    {
        $this->gameSetup = TestingHelper::getGameSetupBaseClass(
            new GameOptionCollectionPowered(),
            new GameOptionValueCollectionPowered()
        );
        $this->box = $this->getGameBox();

        $expected = array_merge(
            [
                'slug' => $this->slug,
                'name' => $this->name,
                'description' => $this->description,
                'durationInMinutes' => $this->durationInMinutes,
                'minPlayerAge' => $this->minPlayerAge,
                'isActive' => $this->isActive,
                'isPremium' => $this->isPremium,
            ],
            ['numberOfPlayersDescription' => '2-3'],
            ['options' =>
                [
                    'numberOfPlayers' => [
                        'availableValues' => [['label' => '2 Players', 'value' => 2], ['label' => '3 Players', 'value' => 3]],
                        'defaultValue' => 2,
                        'type' => GameOptionTypeGeneric::Radio,
                        'name' => $this->box->getGameSetup()->getOption('numberOfPlayers')->getName(),
                        'description' => $this->box->getGameSetup()->getOption('numberOfPlayers')->getDescription(),
                    ],
                    'autostart' => [
                        'availableValues' => [['label' => 'Enabled', 'value' => 1], ['label' => 'Disabled', 'value' => 0]],
                        'defaultValue' => 1,
                        'type' => GameOptionTypeGeneric::Checkbox,
                        'name' => $this->box->getGameSetup()->getOption('autostart')->getName(),
                        'description' => $this->box->getGameSetup()->getOption('autostart')->getDescription(),
                    ],
                    'forfeitAfter' => [
                        'availableValues' => [['label' => 'Disabled', 'value' => 0]],
                        'defaultValue' => 0,
                        'type' => GameOptionTypeGeneric::Radio,
                        'name' => $this->box->getGameSetup()->getOption('forfeitAfter')->getName(),
                        'description' => $this->box->getGameSetup()->getOption('forfeitAfter')->getDescription(),
                    ],
                ],
            ],
        );

        $this->assertEquals($expected, $this->box->toArray());
    }
}
