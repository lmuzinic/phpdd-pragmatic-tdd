<?php
declare(strict_types=1);

namespace BallGame\Tests\Domain;

use BallGame\Domain\GetTheBallRolling;
use PHPUnit\Framework\TestCase;

class GetTheBallRollingTest extends TestCase
{
    /**
     * @var GetTheBallRolling
     */
    private $ball;

    public function setUp()
    {
        $this->ball = GetTheBallRolling::create('Hello');
    }

    public function testGetNameReturnsCreatedName()
    {
        $this->assertSame('Hello', $this->ball->getName());
    }

    public function testBinaryGapWhenThereAreNoGaps()
    {
        // 111
        $binaryGap = $this->ball->getBinaryGap(7);

        $this->assertSame(0, $binaryGap);
    }

    public function testBinaryGapWhenThereGapSizeTwo()
    {
        // 1001
        $binaryGap = $this->ball->getBinaryGap(9);

        $this->assertSame(2, $binaryGap);
    }

    public function testBinaryGapWhenThereAreTwoGaps()
    {
        // 10000100
        $binaryGap = $this->ball->getBinaryGap(132);

        $this->assertSame(4, $binaryGap);
    }

    public function testBinaryGapWhenThereAreTwoGapsAnTheLatterIsGreater()
    {
        // 11010001
        $binaryGap = $this->ball->getBinaryGap(209);

        $this->assertSame(3, $binaryGap);
    }

    public function testOddOccurrencesWhenThereIsOnlyOneElement()
    {
        $input = [42];

        $oddOccurrences = $this->ball->getOddOccurrences($input);

        $this->assertSame(42, $oddOccurrences);
    }

    public function testOddOccurrencesWhenThereAreThreeElements()
    {
        $input = [1, 42, 1];

        $oddOccurrences = $this->ball->getOddOccurrences($input);

        $this->assertSame(42, $oddOccurrences);
    }

    public function testOddOccurrencesWhenThereAreThreeElementsAndOddOneIsFirst()
    {
        $input = [42, 1, 1];

        $oddOccurrences = $this->ball->getOddOccurrences($input);

        $this->assertSame(42, $oddOccurrences);
    }

    public function testOddOccurrencesWhenThereAreThreeElementsAndOddOneIsLast()
    {
        $input = [42, 1, 1];

        $oddOccurrences = $this->ball->getOddOccurrences($input);

        $this->assertSame(42, $oddOccurrences);
    }
}
