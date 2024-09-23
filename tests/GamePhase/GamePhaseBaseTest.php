<?php

namespace Tests\GamePhase;

use MyDramGames\Core\GamePhase\GamePhase;
use MyDramGames\Core\GamePhase\GamePhaseBase;
use PHPUnit\Framework\TestCase;

class GamePhaseBaseTest extends TestCase
{
    protected GamePhaseBase $phase;

    public function setUp(): void
    {
        $this->phase = $this->getGamePhaseBase();
    }

    protected function getGamePhaseBase(): GamePhaseBase
    {
        return new class() extends GamePhaseBase {

            public const string PHASE_KEY = 'key';
            protected const string PHASE_NAME = 'name';
            protected const string PHASE_DESCRIPTION = 'description';

            public function getNextPhase(bool $lastAttempt): GamePhase
            {
                return $this;
            }
        };
    }

    public function testGetKay(): void
    {
        $this->assertEquals($this->phase::PHASE_KEY, $this->phase->getKey());
    }

    public function testGetName(): void
    {
        $this->assertEquals('name', $this->phase->getName());
    }

    public function testGetDescription(): void
    {
        $this->assertEquals('description', $this->phase->getDescription());
    }
}
