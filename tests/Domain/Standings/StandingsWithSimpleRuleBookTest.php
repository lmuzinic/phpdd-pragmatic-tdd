<?php
declare(strict_types=1);

namespace BallGame\Tests;

use BallGame\Domain\Match\Match;
use BallGame\Domain\RuleBook\SimpleRuleBook;
use BallGame\Domain\Standings\Standings;
use BallGame\Domain\Team\Team;
use BallGame\Infrastructure\Repository\MatchRepository;
use PHPUnit\Framework\TestCase;

class StandingsWithSimpleRuleBookTest extends TestCase
{
    /**
     * @var Standings
     */
    protected $standings;

    public function setUp()
    {
        $ruleBook = new SimpleRuleBook();
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

        // When
        $actualStandings = $this->standings->getSortedStandings();

        // Then
        $this->assertSame(
            [
                ['Tigers', 2, 1, 3],
                ['Elephants', 1, 2, 0],
            ],
            $actualStandings
        );
    }

    /**
     * @throws \BallGame\Domain\Exception\BadMatchException
     * @throws \BallGame\Domain\Exception\BadTeamNameException
     *
     * @group integration
     */
    public function testGetStandingsReturnsSortedLeagueStandingsWhenSecondTeamEndsUpInFirstPlace()
    {
        // Given
        $tigers = Team::create('Tigers');
        $elephants = Team::create('Elephants');

        $match = Match::create($tigers, $elephants, 0, 1);

        $this->standings->record($match);

        // When
        $actualStandings = $this->standings->getSortedStandings();

        // Then
        $this->assertSame(
            [
                ['Elephants', 1, 0, 3],
                ['Tigers', 0, 1, 0],
            ],
            $actualStandings
        );
    }
}
