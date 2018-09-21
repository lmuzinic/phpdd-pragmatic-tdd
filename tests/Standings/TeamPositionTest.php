<?php
declare(strict_types=1);

namespace BallGame\Tests\Standings;

use BallGame\Standings\TeamPosition;
use BallGame\Team\Team;
use PHPUnit\Framework\TestCase;

class TeamPositionTest extends TestCase
{
    /**
     * @var TeamPosition
     */
    protected $teamPosition;

    public function setUp()
    {
        $team = Team::create('Some other team');

        $this->teamPosition = new TeamPosition($team);
    }

    public function testGetPointsReturnsZeroWhenThereAreNoGames()
    {
        $this->assertSame(0, $this->teamPosition->getPoints());
    }

    public function testGetPointsReturnsNineAfterThreeWins()
    {
        $this->teamPosition->recordWin();
        $this->teamPosition->recordWin();
        $this->teamPosition->recordWin();

        $this->assertSame(9, $this->teamPosition->getPoints());
    }

    public function testGetPointsScoredReturnsZeroWhenThereAreNoGames()
    {
        $this->assertSame(0, $this->teamPosition->getPointsScored());
    }

    public function testGetPointsScoredAfterThreeGames()
    {
        $this->teamPosition->recordPointsScored(1);
        $this->teamPosition->recordPointsScored(2);
        $this->teamPosition->recordPointsScored(3);

        $this->assertSame(6, $this->teamPosition->getPointsScored());
    }

    public function testGetPointsAgainstReturnsZeroWhenThereAreNoGames()
    {
        $this->assertSame(0, $this->teamPosition->getPointsAgainst());
    }

    public function testGetPointsAgainstAfterThreeGames()
    {
        $this->teamPosition->recordPointsAgainst(10);
        $this->teamPosition->recordPointsAgainst(20);
        $this->teamPosition->recordPointsAgainst(30);

        $this->assertSame(60, $this->teamPosition->getPointsAgainst());
    }
}
