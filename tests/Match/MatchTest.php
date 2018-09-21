<?php
declare(strict_types=1);

namespace BallGame\Tests\Match;

use BallGame\Exception\BadMatchException;
use BallGame\Match\Match;
use BallGame\Team\Team;
use PHPUnit\Framework\TestCase;

class MatchTest extends TestCase
{
    public function testCreateDoesNotAllowAMatchBetweenTheSameTeam()
    {
        $this->expectException(BadMatchException::class);

        Match::create(
            Team::create('Name'),
            Team::create('Name'),
            0,
            0
        );
    }
}
