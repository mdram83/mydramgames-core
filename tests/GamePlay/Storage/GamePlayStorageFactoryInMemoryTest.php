<?php

namespace Tests\GamePlay\Storage;

use MyDramGames\Core\GameInvite\GameInvite;
use MyDramGames\Core\GamePlay\Storage\GamePlayStorageFactoryInMemory;
use MyDramGames\Core\GamePlay\Storage\GamePlayStorageInMemory;
use PHPUnit\Framework\TestCase;

class GamePlayStorageFactoryInMemoryTest extends TestCase
{
    public function testCreate(): void
    {
        $factory = new GamePlayStorageFactoryInMemory();
        $invite = $this->createMock(GameInvite::class);

        $this->assertInstanceOf(GamePlayStorageInMemory::class, $factory->create($invite));
    }
}
