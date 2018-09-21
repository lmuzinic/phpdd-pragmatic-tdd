<?php
declare(strict_types=1);

namespace BallGame\Tests\Team;

use BallGame\Exception\BadTeamNameException;
use BallGame\Team\Team;
use PHPUnit\Framework\TestCase;

class TeamTest extends TestCase
{
    public function testCreateDoesNotAllowTeamWithNoName()
    {
        $this->expectException(BadTeamNameException::class);

        Team::create('');
    }
}
