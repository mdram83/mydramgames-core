<?php

namespace MyDramGames\Core\GamePlay\Traits;

use MyDramGames\Utils\Player\Player;

trait GetActivePlayerPropertyTrait
{
    protected ?Player $activePlayer;

    /**
     * @inheritDoc
     */
    final public function getActivePlayer(): ?Player
    {
        return $this->activePlayer;
    }
}
