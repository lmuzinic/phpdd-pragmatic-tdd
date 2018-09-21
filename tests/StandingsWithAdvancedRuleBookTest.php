<?php
declare(strict_types=1);

namespace BallGame\Tests;

use BallGame\Match\Match;
use BallGame\RuleBook\AdvancedRuleBook;
use BallGame\Standings\Standings;
use BallGame\Team\Team;
use PHPUnit\Framework\TestCase;

class StandingsWithAdvancedRuleBookTest extends TestCase
{
    /**
     * @var Standings
     */
    protected $standings;

    public function setUp()
    {
        $ruleBook = new AdvancedRuleBook();
        $this->standings = new Standings($ruleBook);
    }

    public function testGetStandingsReturnsSortedLeagueStandings()
    {
        // Given
        $tigers = Team::create('Tigers');
        $elephants = Team::create('Elephants');

        $match = Match::create($tigers, $elephants, 2, 1);
        $this->standings->record($match);

        $match = Match::create($tigers, $elephants, 0, 3);
        $this->standings->record($match);

        // When
        $actualStandings = $this->standings->getSortedStandings();

        // Then
        $this->assertSame(
            [
                ['Elephants', 4, 2, 3],
                ['Tigers', 2, 4, 3],
            ],
            $actualStandings
        );
    }
}
