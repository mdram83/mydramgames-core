<?php

namespace MyDramGames\Core\GameBox;

interface GameBoxRepository
{
    /**
     * Method to retrieve a single GameBox object by its unique slug
     * @param string $slug
     * @return GameBox
     */
    public function getOne(string $slug): GameBox;

    /**
     * Method to retrieve all available GameBox objects
     * @return GameBoxCollection
     */
    public function getAll(): GameBoxCollection;
}
