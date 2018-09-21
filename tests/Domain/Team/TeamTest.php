<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain\Team;

use BallGame\Domain\Exception\BadTeamNameException;
use BallGame\Domain\Team\Team;
use PHPUnit\Framework\TestCase;

class TeamTest extends TestCase
{
    public function testCreateDoesNotAllowTeamWithNoName()
    {
        $this->expectException(BadTeamNameException::class);

        Team::create('');
    }
}
