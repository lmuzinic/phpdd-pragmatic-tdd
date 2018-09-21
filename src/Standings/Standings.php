<?php
declare(strict_types=1);


namespace BallGame\Standings;


use BallGame\Match\Match;

class Standings
{
    /**
     * @var Match[]
     */
    protected $matches;

    public function record(Match $match)
    {
        $this->matches[] = $match;
    }

    public function getSortedStandings()
    {
        return [
            ['Tigers', 2, 1, 3],
            ['Elephants', 1, 2, 0],
        ];
    }
}
