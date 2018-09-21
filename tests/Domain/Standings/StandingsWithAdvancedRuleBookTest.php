<?php
declare(strict_types=1);

namespace BallGame\Tests;

use BallGame\Domain\Match\Match;
use BallGame\Domain\RuleBook\AdvancedRuleBook;
use BallGame\Domain\Standings\Standings;
use BallGame\Domain\Team\Team;
use BallGame\Infrastructure\Repository\MatchRepository;
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
        $repository = new MatchRepository();

        $this->standings = new Standings($ruleBook, $repository);
    }

    /**
     * @throws \BallGame\Domain\Exception\BadMatchException
     * @throws \BallGame\Domain\Exception\BadTeamNameException
     *
     * @group integration
     */
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
