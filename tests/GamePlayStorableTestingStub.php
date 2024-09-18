<?php

namespace Tests;

use MyDramGames\Core\GameMove\GameMove;
use MyDramGames\Core\GamePlay\GamePlay;
use MyDramGames\Core\GamePlay\GamePlayStorableBase;
use MyDramGames\Utils\Player\Player;
use PHPUnit\Framework\MockObject\MockObject;

class GamePlayStorableTestingStub extends GamePlayStorableBase implements GamePlay
{
    protected array $words;
    protected const ?string GAME_MOVE_CLASS = MockObject::class;

    /**
     * @inheritDoc
     */
    public function handleMove(GameMove $move): void
    {
        $this->validateGamePlayer($move->getPlayer());
        $this->validateNotFinished();
        $this->validateMove($move);

        $this->words[] = $move->getDetails()['word'];
        $this->saveData();
    }

    /**
     * @inheritDoc
     */
    public function handleForfeit(Player $player): void
    {
        $this->validateNotFinished();
        $this->storage->setFinished();
    }

    /**
     * @inheritDoc
     */
    public function getSituation(Player $player): array
    {
        $activePlayerName = $this->getActivePlayer()->getName();
        return [
            'words' => $this->words,
            'activePlayer' => $activePlayerName,
            'yourId' => $this->getPlayerByName($player->getName())->getId(),
        ];
    }

    /**
     * @inheritDoc
     */
    protected function initialize(): void
    {
        $this->words = [];
        $this->activePlayer = $this->getGameInvite()->getPlayers()->getOne(2);
    }

    /**
     * @inheritDoc
     */
    protected function saveData(): void
    {
        $this->storage->setGameData([
            'words' => $this->words,
            'activePlayer' => $this->activePlayer,
        ]);
    }

    /**
     * @inheritDoc
     */
    protected function loadData(): void
    {
        $data = $this->storage->getGameData();
        $this->words = $data['words'];
        $this->activePlayer = $data['activePlayer'];
    }

    /**
     * @inheritDoc
     */
    protected function configureGamePlayServices(): void
    {

    }

    /**
     * @inheritDoc
     */
    protected function runConfigurationAfterHooks(): void
    {

    }
}