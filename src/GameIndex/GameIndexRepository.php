<?php

namespace MyDramGames\Core\GameIndex;

interface GameIndexRepository
{
    /**
     * Provides single GameIndex element for specific game
     * @param string $slug
     * @return GameIndex
     */
    public function getOne(string $slug): GameIndex;

    /**
     * Provides all GameIndex elements for all available games
     * @return GameIndexCollection
     */
    public function getAll(): GameIndexCollection;
}
