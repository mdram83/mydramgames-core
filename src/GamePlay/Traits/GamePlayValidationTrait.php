<?php

namespace MyDramGames\Core\GamePlay\Traits;

use MyDramGames\Core\Exceptions\GamePlayException;
use MyDramGames\Core\GameMove\GameMove;
use MyDramGames\Utils\Player\Player;

trait GamePlayValidationTrait
{
    /**
     * @throws GamePlayException
     */
    final protected function validateMove(GameMove $move): void
    {
        if (!$this->isMoveValidClass($move)) {
            throw new GamePlayException(GamePlayException::MESSAGE_INCOMPATIBLE_MOVE);
        }

        if (!$this->isMoveForActivePlayer($move)) {
            throw new GamePlayException(GamePlayException::MESSAGE_NOT_CURRENT_PLAYER);
        }
    }

    /**
     * @param GameMove $move
     * @return bool
     */
    final protected function isMoveValidClass(GameMove $move): bool
    {
        return is_a($move, $this::GAME_MOVE_CLASS);
    }

    /**
     * @param GameMove $move
     * @return bool
     */
    final protected function isMoveForActivePlayer(GameMove $move): bool
    {
        return $move->getPlayer()->getId() === $this->getActivePlayer()?->getId();
    }

    /**
     * @throws GamePlayException
     */
    final protected function validateNotFinished(): void
    {
        if ($this->isFinished()) {
            throw new GamePlayException(GamePlayException::MESSAGE_MOVE_ON_FINISHED_GAME);
        }
    }

    /**
     * @throws GamePlayException
     */
    final protected function validateGamePlayer(Player $player): void
    {
        if (!$this->getPlayers()->exist($player->getId())) {
            throw new GamePlayException(GamePlayException::MESSAGE_NOT_PLAYER);
        }
    }
}
