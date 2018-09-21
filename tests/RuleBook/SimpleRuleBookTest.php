<?php
declare(strict_types=1);

namespace BallGame\Tests\RuleBook;

use BallGame\RuleBook\SimpleRuleBook;
use BallGame\Standings\TeamPosition;
use BallGame\Team\Team;
use PHPUnit\Framework\TestCase;

class SimpleRuleBookTest extends TestCase
{
    /**
     * @var SimpleRuleBook
     */
    protected $simpleRuleBook;

    /**
     * @var TeamPosition|\PHPUnit_Framework_MockObject_MockObject $teamAPosition
     */
    protected $teamAPosition;

    /**
     * @var TeamPosition|\PHPUnit_Framework_MockObject_MockObject $teamAPosition
     */
    protected $teamBPosition;

    public function setUp()
    {
        $this->teamAPosition = $this->getMockBuilder(TeamPosition::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->teamBPosition = $this->getMockBuilder(TeamPosition::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->simpleRuleBook = new SimpleRuleBook();
    }

    public function testDecideReturnsLessThenZeroWhenFirstPositionIsGreaterThanSecond()
    {
        $this->teamAPosition->method('getPoints')->willReturn(10);
        $this->teamBPosition->method('getPoints')->willReturn(1);

        $this->assertSame(-1, $this->simpleRuleBook->decide($this->teamAPosition, $this->teamBPosition));
    }

    public function testDecideReturnsGreaterThanZeroWhenSecondPositionIsGreaterThanFirst()
    {
        $this->teamAPosition->method('getPoints')->willReturn(1);
        $this->teamBPosition->method('getPoints')->willReturn(10);

        $this->assertSame(1, $this->simpleRuleBook->decide($this->teamAPosition, $this->teamBPosition));
    }

    public function testDecideReturnsZeroWhenBothPositionsAreTheSame()
    {
        $this->teamAPosition->method('getPoints')->willReturn(10);
        $this->teamBPosition->method('getPoints')->willReturn(10);

        $this->assertSame(0, $this->simpleRuleBook->decide($this->teamAPosition, $this->teamBPosition));
    }
}
