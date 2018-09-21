<?php
declare(strict_types=1);


namespace BallGame\Domain\Standings;


use BallGame\Domain\Match\Match;
use BallGame\Domain\RuleBook\RuleBookInterface;
use BallGame\Infrastructure\Repository\MatchRepository;

class Standings
{
    /**
     * @var TeamPosition[]
     */
    protected $teamPositions;

    /**
     * @var RuleBookInterface
     */
    protected $ruleBook;

    /**
     * @var MatchRepository
     */
    private $matchRepository;

    public function __construct(RuleBookInterface $ruleBook, MatchRepository $matchRepository)
    {
        $this->ruleBook = $ruleBook;
        $this->matchRepository = $matchRepository;
    }

    public function record(Match $match)
    {
        $this->matchRepository->save($match);
    }

    public function getSortedStandings()
    {
        foreach ($this->matchRepository->findAll() as $match) {
            $homeTeamPosition = $this->getHomeTeam($match);
            $awayTeamPosition = $this->getAwayTeam($match);

            // Yay, home team won!
            if ($match->getHomeTeamPoints() > $match->getAwayTeamPoints()) {
                $homeTeamPosition->recordWin();
            }

            // Boo, away team won :(
            if ($match->getAwayTeamPoints() > $match->getHomeTeamPoints()) {
                $awayTeamPosition->recordWin();
            }

            $homeTeamPosition->recordPointsScored($match->getHomeTeamPoints());
            $homeTeamPosition->recordPointsAgainst($match->getAwayTeamPoints());

            $awayTeamPosition->recordPointsScored($match->getAwayTeamPoints());
            $awayTeamPosition->recordPointsAgainst($match->getHomeTeamPoints());
        }

        uasort($this->teamPositions, [$this->ruleBook, 'decide']);

        $finalStandings = [];
        foreach ($this->teamPositions as $teamPosition) {
            $finalStandings[] = [
                $teamPosition->getTeam()->getName(),
                $teamPosition->getPointsScored(),
                $teamPosition->getPointsAgainst(),
                $teamPosition->getPoints()
            ];
        }

        return $finalStandings;
    }

    /**
     * @param $match
     * @return TeamPosition
     */
    private function getHomeTeam(Match $match): TeamPosition
    {
        if (!isset($this->teamPositions[sha1($match->getHomeTeam()->getName())])) {
            $this->teamPositions[sha1($match->getHomeTeam()->getName())] = new TeamPosition($match->getHomeTeam());
        }
        $homeTeamPosition = $this->teamPositions[sha1($match->getHomeTeam()->getName())];
        return $homeTeamPosition;
    }

    /**
     * @param $match
     * @return TeamPosition
     */
    private function getAwayTeam(Match $match): TeamPosition
    {
        if (!isset($this->teamPositions[sha1($match->getAwayTeam()->getName())])) {
            $this->teamPositions[sha1($match->getAwayTeam()->getName())] = new TeamPosition($match->getAwayTeam());
        }
        $awayTeamPosition = $this->teamPositions[sha1($match->getAwayTeam()->getName())];
        return $awayTeamPosition;
    }
}
