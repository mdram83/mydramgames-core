<?php

namespace MyDramGames\Core\GameBox;

use MyDramGames\Core\Exceptions\GameBoxException;
use MyDramGames\Core\Exceptions\GameSetupException;
use MyDramGames\Core\GameMove\GameMoveFactory;
use MyDramGames\Core\GamePlay\GamePlay;
use MyDramGames\Core\GameSetup\GameSetup;

class GameBoxGeneric implements GameBox
{
    public function __construct(
        protected string $slug,
        protected string $name,
        protected GameSetup $gameSetup,
        protected string $gamePlayClassname,
        protected string $gameMoveFactoryClassname,
        protected bool $isActive,
        protected bool $isPremium,
        protected ?string $description,
        protected ?int $durationInMinutes,
        protected ?int $minPlayerAge,
    )
    {

    }

    /**
     * @inheritDoc
     */
    public function getSlug(): string
    {
        $this->validateNotEmpty($this->slug);
        return $this->slug;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        $this->validateNotEmpty($this->name);
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @inheritDoc
     */
    public function getNumberOfPlayersDescription(): string
    {
        try {
            $option = $this->getGameSetup()->getNumberOfPlayers();
        } catch (GameSetupException) {
            throw new GameBoxException(GameBoxException::MESSAGE_INCORRECT_CONFIGURATION);
        }

        $values = array_map(fn($value) => $value->getValue() , $option->getAvailableValues()->toArray());

        if (!$this->hasConsecutiveNumberOfPlayers($values)) {
            return implode(', ', $values);
        }

        if (count($values) === 1) {
            return $values[0];
        }

        return min($values) . '-' . max($values);
    }

    /**
     * @inheritDoc
     */
    public function getDurationInMinutes(): ?int
    {
        return $this->durationInMinutes;
    }

    /**
     * @inheritDoc
     */
    public function getMinPlayerAge(): ?int
    {
        return $this->minPlayerAge;
    }

    /**
     * @inheritDoc
     */
    public function getGameSetup(): GameSetup
    {
        if (!$this->gameSetup->isSetUp()) {
            throw new GameBoxException(GameBoxException::MESSAGE_INCORRECT_CONFIGURATION);
        }

        return $this->gameSetup;
    }

    /**
     * @inheritDoc
     */
    public function getGamePlayClassname(): string
    {
        $this->validateClassnameImplementsInterface($this->gamePlayClassname, GamePlay::class);
        return $this->gamePlayClassname;
    }

    /**
     * @inheritDoc
     */
    public function getGameMoveFactoryClassname(): string
    {
        $this->validateClassnameImplementsInterface($this->gameMoveFactoryClassname, GameMoveFactory::class);
        return $this->gameMoveFactoryClassname;
    }

    /**
     * @inheritDoc
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @inheritDoc
     */
    public function isPremium(): bool
    {
        return $this->isPremium;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'slug' => $this->getSlug(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'numberOfPlayersDescription' => $this->getNumberOfPlayersDescription(),
            'durationInMinutes' => $this->getDurationInMinutes(),
            'minPlayerAge' => $this->getMinPlayerAge(),
            'isActive' => $this->isActive(),
            'isPremium' => $this->isPremium(),

            'options' => array_map(fn($option) => [
                'availableValues' => array_map(
                    fn($optionValue) => ['label' => $optionValue->getLabel(), 'value' => $optionValue->getValue()],
                    $option->getAvailableValues()->toArray()
                ),
                'defaultValue' => $option->getDefaultValue()->value,
                'type' => $option->getType(),
                'name' => $option->getName(),
                'description' => $option->getDescription(),
            ], $this->getGameSetup()->getAllOptions()->toArray()),

        ];
    }

    /**
     * @throws GameBoxException
     */
    protected function validateNotEmpty(string $value): void
    {
        if ($value === '') {
            throw new GameBoxException(GameBoxException::MESSAGE_INCORRECT_CONFIGURATION);
        }
    }

    /**
     * @throws GameBoxException
     */
    protected function validateClassnameImplementsInterface(string $class, string $interface): void
    {
        if (!class_exists($class) || !in_array($interface, class_implements($class))) {
            throw new GameBoxException(GameBoxException::MESSAGE_INCORRECT_CONFIGURATION);
        }
    }

    protected function hasConsecutiveNumberOfPlayers(array $numberOfPlayers): bool
    {
        for ($i = 1; $i < count($numberOfPlayers); $i++) {
            if ($numberOfPlayers[$i] - $numberOfPlayers[$i - 1] !== 1) {
                return false;
            }
        }
        return true;
    }
}
