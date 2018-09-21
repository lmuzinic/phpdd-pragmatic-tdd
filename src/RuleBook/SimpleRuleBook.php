<?php
declare(strict_types=1);


namespace BallGame\RuleBook;


use BallGame\Standings\TeamPosition;

class SimpleRuleBook implements RuleBookInterface
{
    public function decide(TeamPosition $teamA, TeamPosition $teamB)
    {
        if ($teamA->getPoints() > $teamB->getPoints()) {
            return -1;
        }

        if ($teamB->getPoints() > $teamA->getPoints()) {
            return 1;
        }

        return 0;
    }
}
