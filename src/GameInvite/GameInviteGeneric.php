<?php

namespace MyDramGames\Core\GameInvite;

use MyDramGames\Core\Exceptions\GameBoxException;
use MyDramGames\Core\Exceptions\GameInviteException;
use MyDramGames\Core\Exceptions\GameOptionException;
use MyDramGames\Core\Exceptions\GameSetupException;
use MyDramGames\Core\GameBox\GameBox;
use MyDramGames\Core\GameOption\GameOptionConfigurationCollection;
use MyDramGames\Core\GameSetup\GameSetup;
use MyDramGames\Utils\Exceptions\CollectionException;
use MyDramGames\Utils\Player\Player;
use MyDramGames\Utils\Player\PlayerCollection;

class GameInviteGeneric implements GameInvite
{
    protected Player $host;
    /**
     * @throws GameInviteException
     * @throws CollectionException
     */
    public function __construct(
        protected int|string $id,
        protected GameBox $gameBox,
        protected GameOptionConfigurationCollection $configurations,
        protected PlayerCollection $players,
    )
    {
        $this->validateId();
        $this->configureOptions();
        $this->players->reset();
    }

    /**
     * @inheritDoc
     */
    public function getId(): int|string
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     * @throws GameInviteException|GameOptionException
     * @throws CollectionException
     */
    public function addPlayer(Player $player, bool $host = false): void
    {
        $this->validateAddedPlayer($player, $host);

        if ($host) {
            $this->host = $player;
        }
        $this->players->add($player);
    }

    /**
     * @inheritDoc
     */
    public function getPlayers(): PlayerCollection
    {
        return $this->players;
    }

    /**
     * @inheritDoc
     */
    public function isPlayer(Player $player): bool
    {
        return $this->players->exist($player->getId());
    }

    /**
     * @inheritDoc
     * @throws GameInviteException
     */
    public function getHost(): Player
    {
        $this->validateHasHost();
        return $this->host;
    }

    /**
     * @inheritDoc
     * @throws GameInviteException
     */
    public function isHost(Player $player): bool
    {
        $this->validateHasHost();
        return $this->host->getId() === $player->getId();
    }

    /**
     * @inheritDoc
     * @throws GameInviteException
     */
    public function getGameSetup(): GameSetup
    {
        try {
            return $this->getGameBox()->getGameSetup();
        } catch (GameBoxException) {
            throw new GameInviteException(GameInviteException::MESSAGE_GAME_SETUP_NOT_SET);
        }
    }

    /**
     * @inheritDoc
     */
    public function getGameBox(): GameBox
    {
        return $this->gameBox;
    }

    /**
     * @inheritDoc
     * @throws GameInviteException
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'host' => ['name' => $this->getHost()->getName()],
            'options' => array_map(fn($option) => $option->getConfiguredValue(), $this->getGameSetup()->getAllOptions()->toArray()),
            'players' => array_map(fn($player) => ['name' => $player->getName()], $this->getPlayers()->toArray()),
        ];
    }

    /**
     * @throws GameInviteException
     * @throws GameOptionException
     */
    protected function getConfiguredNumberOfPlayers(): int
    {
        return $this->getGameSetup()->getNumberOfPlayers()->getConfiguredValue()->getValue();
    }

    protected function hasHost(): bool
    {
        return isset($this->host);
    }

    /**
     * @return void
     * @throws GameInviteException
     */
    public function validateId(): void
    {
        if ($this->id === '') {
            throw new GameInviteException(GameInviteException::MESSAGE_GAME_NOT_FOUND);
        }
    }

    /**
     * @return void
     * @throws GameInviteException
     */
    public function configureOptions(): void
    {
        try {
            $setup = $this->gameBox->getGameSetup();

            if (!$setup->isSetUp()) {
                throw new GameInviteException(GameInviteException::MESSAGE_GAME_SETUP_NOT_SET);
            }

            $setup->configureOptions($this->configurations);
        } catch (GameBoxException|GameSetupException) {
            throw new GameInviteException(GameInviteException::MESSAGE_GAME_SETUP_NOT_SET);
        }
    }

    /**
     * @param Player $player
     * @param bool $host
     * @return void
     * @throws GameInviteException
     * @throws GameOptionException
     */
    public function validateAddedPlayer(Player $player, bool $host): void
    {
        if ($this->players->count() >= $this->getConfiguredNumberOfPlayers()) {
            throw new GameInviteException(GameInviteException::MESSAGE_TOO_MANY_PLAYERS);
        }

        if ($this->isPlayer($player)) {
            throw new GameInviteException(GameInviteException::MESSAGE_PLAYER_ALREADY_ADDED);
        }

        if ($this->hasHost() && $host === true) {
            throw new GameInviteException(GameInviteException::MESSAGE_HOST_ALREADY_ADDED);
        }

        if (!$this->hasHost() && $host === false) {
            throw new GameInviteException(GameInviteException::MESSAGE_HOST_NOT_SET);
        }
    }

    /**
     * @return void
     * @throws GameInviteException
     */
    public function validateHasHost(): void
    {
        if (!$this->hasHost()) {
            throw new GameInviteException(GameInviteException::MESSAGE_HOST_NOT_SET);
        }
    }
}
