<?php

namespace Tests\GameSetup;

use MyDramGames\Core\Exceptions\GameSetupException;
use MyDramGames\Core\GameOption\GameOptionCollection;
use MyDramGames\Core\GameOption\GameOptionValueCollection;
use MyDramGames\Core\GameSetup\GameSetup;
use MyDramGames\Core\GameSetup\GameSetupBaseRepository;
use PHPUnit\Framework\TestCase;
use Tests\GameSetupBaseTestingStub;

class GameSetupBaseRepositoryTest extends TestCase
{
    protected GameSetupBaseRepository $repository;
    protected string $gameSetupClassname;

    public function setUp(): void
    {
        $this->repository = new GameSetupBaseRepository(
            $this->createMock(GameOptionCollection::class),
            $this->createMock(GameOptionValueCollection::class),
        );

        $this->gameSetupClassname = GameSetupBaseTestingStub::class;
    }

    public function testGetOneByClassnameThrowExceptionMissingClass(): void
    {
        $this->expectException(GameSetupException::class);
        $this->expectExceptionMessage(GameSetupException::MESSAGE_NO_ABS_FACTORY);

        $this->repository->getOneByClassname('SuchClassDoesNotExist');
    }

    public function testGetOneByClassnameThrowExceptionMissingRightInterface(): void
    {
        $this->expectException(GameSetupException::class);
        $this->expectExceptionMessage(GameSetupException::MESSAGE_NO_ABS_FACTORY);

        $this->repository->getOneByClassname(GameSetupException::class);
    }

    public function testGetOneByClassname(): void
    {
        $this->assertInstanceOf(
            GameSetup::class,
            $this->repository->getOneByClassname($this->gameSetupClassname)
        );
    }
}
