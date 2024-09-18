<?php

namespace MyDramGames\Core\GameIndex;

use MyDramGames\Core\GameBox\GameBox;
use MyDramGames\Core\GameBox\GameBoxGeneric;
use MyDramGames\Core\GameOption\GameOptionCollection;
use MyDramGames\Core\GameOption\GameOptionValueCollection;
use MyDramGames\Core\GamePlay\Services\GamePlayServicesProvider;
use MyDramGames\Core\GamePlay\Storage\GamePlayStorageFactory;
use MyDramGames\Utils\Exceptions\CollectionException;

/**
 * You can extend this GameIndex abstract class to take advantage of repeatable elements, mainly for Storable game plays
 */
abstract class GameIndexStorableBase implements GameIndex
{
    /**
     * Adjust below constants accordingly to information you want to present about specific Game
     */
    public const string SLUG = '';
    public const string NAME = '';
    public const ?string DESCRIPTION = '';
    public const ?int DURATION_IN_MINUTES = 0;
    public const ?int MIN_PLAYER_AGE = 0;
    public const bool IS_ACTIVE = false;
    public const bool IS_PREMIUM = false;

    /**
     * Enter information about specific for this game implementation of GamePlay interface.
     */
    protected const string GAMEPLAY_CLASSNAME = '';

    /**
     * @throws CollectionException
     */
    final public function __construct(
        protected GameOptionCollection $optionsHandler,
        protected GameOptionValueCollection $valuesHandler,
        protected GamePlayStorageFactory $gamePlayStorageFactory,
        protected GamePlayServicesProvider $gamePlayServicesProvider,
    )
    {
        $this->optionsHandler->reset();
        $this->valuesHandler->reset();

        $this->configureGameIndex();
    }

    /**
     * This is template method that can be used in specific GameIndex implementations to configure additional things.
     * E.g. you can set up an internal parameter for GameMoveFactory (if needed) or fulfill any other needs.
     * @return void
     */
    abstract protected function configureGameIndex(): void;

    /**
     * @inheritDoc
     */
    final public function getSlug(): string
    {
        return $this::SLUG;
    }

    /**
     * @inheritDoc
     * @param bool|null $isActiveOverwrite
     * @param bool|null $isPremiumOverwrite
     * @return GameBox
     */
    final public function getGameBox(?bool $isActiveOverwrite = null, ?bool $isPremiumOverwrite = null): GameBox
    {
        return new GameBoxGeneric(
            $this::SLUG,
            $this::NAME,
            $this->getGameSetup(),
            $isActiveOverwrite ?? $this::IS_ACTIVE,
            $isPremiumOverwrite ?? $this::IS_PREMIUM,
            $this::DESCRIPTION,
            $this::DURATION_IN_MINUTES,
            $this::MIN_PLAYER_AGE
        );
    }

    final public function getGamePlayClassname(): string
    {
        return $this::GAMEPLAY_CLASSNAME;
    }
}
