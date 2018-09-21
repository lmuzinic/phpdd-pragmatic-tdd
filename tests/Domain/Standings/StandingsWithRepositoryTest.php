<?php
declare(strict_types=1);

namespace BallGame\Tests;

use BallGame\Domain\Match\Match;
use BallGame\Domain\RuleBook\SimpleRuleBook;
use BallGame\Domain\Standings\Standings;
use BallGame\Domain\Team\Team;
use BallGame\Infrastructure\Repository\MatchRepository;
use PHPUnit\Framework\TestCase;

class StandingsWithRepositoryTest extends TestCase
{
    /**
     * @var Standings
     */
    protected $standings;

    /**
     * @var MatchRepository
     */
    protected $repository;

    public function setUp()
    {
        $ruleBook = new SimpleRuleBook();
        $this->repository = $this->getMockBuilder(MatchRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->standings = new Standings($ruleBook, $this->repository);
    }

    public function testGetStandingsFetchFromRepository()
    {
        $this->repository->method('findAll')->willReturn([
            Match::create(
                Team::create('Tigers'),
                Team::create('Elephants'),
                0,
                1
            )
        ]);

        $actualStandings = $this->standings->getSortedStandings();

        $this->assertSame(
            [
                ['Elephants', 1, 1, 0, 3],
                ['Tigers', 1, 0, 1, 0],
            ],
            $actualStandings
        );
    }

    public function testGetStandingsWhenTeamsHavePlayedTiedGame()
    {
        $this->repository->method('findAll')->willReturn([
            Match::create(
                Team::create('Tigers'),
                Team::create('Elephants'),
                0,
                1
            ),
            Match::create(
                Team::create('Elephants'),
                Team::create('Tigers'),
                1,
                1
            )
        ]);

        $actualStandings = $this->standings->getSortedStandings();

        $this->assertSame(
            [
                ['Elephants', 2, 2, 1, 4],
                ['Tigers', 2, 1, 2, 1],
            ],
            $actualStandings
        );
    }

    public function testRecordSavesMatchInRepository()
    {
        /** @var Match|\PHPUnit_Framework_MockObject_MockObject $match */
        $match = $this->getMockBuilder(Match::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repository
            ->expects($this->once())
            ->method('save');

        $this->standings->record($match);
    }
}
