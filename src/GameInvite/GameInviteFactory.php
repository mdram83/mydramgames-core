<?php

namespace MyDramGames\Core\GameInvite;

use MyDramGames\Core\GameOption\GameOptionConfigurationCollection;
use MyDramGames\Utils\Player\Player;

interface GameInviteFactory
{
    public function create(string $slug, GameOptionConfigurationCollection $configurations, Player $host): GameInvite;
}
