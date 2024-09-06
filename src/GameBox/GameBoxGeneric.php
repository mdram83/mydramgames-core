<?php

namespace MyDramGames\Core\GameBox;

use MyDramGames\Core\Exceptions\GameBoxException;
use MyDramGames\Core\GameSetup\GameSetup;

class GameBoxGeneric implements GameBox
{
    public function __construct(
        protected string $slug,
        protected string $name,
        protected GameSetup $gameSetup,
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
        $option = $this->getGameSetup()->getNumberOfPlayers();
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
        return $this->gameSetup;
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
