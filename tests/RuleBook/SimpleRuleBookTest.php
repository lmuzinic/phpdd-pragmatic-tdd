<?php
declare(strict_types=1);

namespace BallGame\Tests\RuleBook;

use BallGame\RuleBook\SimpleRuleBook;
use PHPUnit\Framework\TestCase;

class SimpleRuleBookTest extends TestCase
{
    /**
     * @var SimpleRuleBook
     */
    protected $simpleRuleBook;

    public function setUp()
    {
        $this->simpleRuleBook = new SimpleRuleBook();
    }
}
