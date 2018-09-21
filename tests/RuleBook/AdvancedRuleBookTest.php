<?php
declare(strict_types=1);

namespace BallGame\Tests\RuleBook;

use BallGame\RuleBook\AdvancedRuleBook;
use BallGame\Standings\TeamPosition;
use PHPUnit\Framework\TestCase;

class AdvancedRuleBookTest extends TestCase
{
    /**
     * @var AdvancedRuleBook
     */
    protected $advancedRuleBook;

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

        $this->advancedRuleBook = new AdvancedRuleBook();
    }

    public function testDecideReturnsLessThenZeroWhenFirstPositionIsGreaterThanSecond()
    {
        $this->teamAPosition->method('getPoints')->willReturn(10);
        $this->teamBPosition->method('getPoints')->willReturn(1);

        $this->assertSame(-1, $this->advancedRuleBook->decide($this->teamAPosition, $this->teamBPosition));
    }

    public function testDecideReturnsGreaterThanZeroWhenSecondPositionIsGreaterThanFirst()
    {
        $this->teamAPosition->method('getPoints')->willReturn(1);
        $this->teamBPosition->method('getPoints')->willReturn(10);

        $this->assertSame(1, $this->advancedRuleBook->decide($this->teamAPosition, $this->teamBPosition));
    }

    public function testDecideReturnsLessThenZeroWhenFirstPositionPointsScoredAreGreaterThanSecondAndBothHaveEqualPoints()
    {
        $this->teamAPosition->method('getPoints')->willReturn(42);
        $this->teamAPosition->method('getPointsScored')->willReturn(10);

        $this->teamBPosition->method('getPoints')->willReturn(42);
        $this->teamBPosition->method('getPointsScored')->willReturn(1);

        $this->assertSame(-1, $this->advancedRuleBook->decide($this->teamAPosition, $this->teamBPosition));
    }

    public function testDecideReturnsLessThenZeroWhenSecondPositionPointsScoredAreGreaterThanFirstAndBothHaveEqualPoints()
    {
        $this->teamAPosition->method('getPoints')->willReturn(42);
        $this->teamAPosition->method('getPointsScored')->willReturn(1);

        $this->teamBPosition->method('getPoints')->willReturn(42);
        $this->teamBPosition->method('getPointsScored')->willReturn(10);

        $this->assertSame(1, $this->advancedRuleBook->decide($this->teamAPosition, $this->teamBPosition));
    }

    public function testDecideReturnsZeroWhenBothPositionsPointsScoredAreTheSameAndBothHaveEqualPoints()
    {
        $this->teamAPosition->method('getPoints')->willReturn(10);
        $this->teamBPosition->method('getPoints')->willReturn(10);

        $this->assertSame(0, $this->advancedRuleBook->decide($this->teamAPosition, $this->teamBPosition));
    }
}
